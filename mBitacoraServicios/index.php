<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <link href="../plugins/bootstrap-fileinput-master/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="../plugins/VenoBox-master/venobox/venobox.css" type="text/css" media="screen" />
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
        <div class="box box-danger" <?php echo $solo_lectura ?>>
          <div class="box-header">
            <h3 class="box-title">Bitacora de Servicios | Registro de Servicios</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos" enctype="multipart/form-data">
              <input type="text" id="servicio_id" name="servicio_id" value="0" class="hidden">
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fecha">*Proveedor:</label>
                      <select name="id_proveedor" id="id_proveedor" class="form-control"></select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fecha">*Nombre de Encargado:</label>
                      <input type="text" id="encargado" name="encargado" class="form-control" placeholder="Nombre de Encargado">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="llave_banorte">*Fecha</label>
                      <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                        <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha1" name="fecha1">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="gasto">*Gasto:</label>
                      <div class="input-group">
                        <div class="input-group-addon">$</div>
                        <input type="text" class="form-control" name="gasto" id="gasto" placeholder="Gasto">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fecha">*Supervisor:</label>
                      <select name="supervisor" id="supervisor" class="form-control"></select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fecha">*Rubro:</label>
                      <select name="rublo" id="rublo" class="form-control" style="width: 100%"></select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="imagen">*Comentario:</label>
                      <input id="comentario" name="comentario" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="id_sucursal">*Sucursal:</label>
                      <select name="id_sucursal" id="id_sucursal" class="form-control"></select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="imagen">*Fotos:</label>
                      <input id="file-es" name="file-es[]" type="file" multiple>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Bitacora de Servicios | Lista de Servicios</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body" onmouseover="efecto();">
            <div class="table-responsive">
              <table id="lista_servicios" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Proveedor</th>
                    <th>Nombre Encargado</th>
                    <th>Fecha</th>
                    <th>Gasto</th>
                    <th>Sucursal</th>
                    <th>Comm</th>
                    <th>Rublo</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tfooter>
                  <tr>
                    <th>#</th>
                    <th>Proveedor</th>
                    <th>Nombre Encargado</th>
                    <th>Fecha</th>
                    <th>Gasto</th>
                    <th>Sucursal</th>
                    <th>Comm</th>
                    <th>Rublo</th>
                    <th>Acciones</th>
                  </tr>
                </tfooter>
              </table>
            </div>
          </div>
          <div class="box-footer"></div>
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
  <?php include '../footer.php';
  include 'modal_comentario.php';
  include 'modal_rublo.php'; ?>
  <!-- Page script -->
  <script src="../plugins/bootstrap-fileinput-master/js/plugins/piexif.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/js/plugins/sortable.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/js/locales/fr.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/js/locales/es.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/themes/fa/theme.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/themes/explorer-fa/theme.js" type="text/javascript"></script>
  <script src='../plugins/VenoBox-master/venobox/venobox.min.js'></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script>
    function efecto() {
      var test = $('.venobox').venobox();
      // close current item clicking on .closeme
      $(document).on('click', '.closeme', function(e) {
        test.VBclose();
      });
      // go to next item in gallery clicking on .next
      $(document).on('click', '.next', function(e) {
        test.VBnext();
      });
      // go to previous item in gallery clicking on .previous
      $(document).on('click', '.previous', function(e) {
        test.VBprev();
      });
    }

    function cargar_tabla() {
      $('#lista_servicios').dataTable().fnDestroy();
      $('#lista_servicios').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        'paging': false,
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
            title: 'Bitacora Servicios',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Bitacora Servicios',
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
          "url": "tabla.php",
          "dataSrc": "",
          "data": "",
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "Proveedor"
          },
          {
            "data": "Encargado"
          },
          {
            "data": "Fecha"
          },
          {
            "data": "Gasto"
          },
          {
            "data": "Sucursal"
          },
          {
            "data": "Comentario"
          },
          {
            "data": "Rublo",
            "width": "5%"
          },
          {
            "data": "Imagenes",
            "width": "20%"
          }
        ]
      });
    }
    cargar_tabla();
    $.validator.setDefaults({
      submitHandler: function() {
        var f = $(this);
        var formData = new FormData(document.getElementById("form_datos"));
        formData.append("dato", "valor");
        //formData.append(f.attr("name"), $(this)[0].files[0]);
        $.ajax({
            type: "POST",
            url: 'guardar.php',
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
          })
          .done(function(res) {
            if (res == "ok") {
              alertify.success("Registros Guardados Correctamente");
              $('#form_datos')[0].reset();
              cargar_tabla();
              $("#id_proveedor").select2("trigger", "select", {
                data: {
                  id: '',
                  text: ''
                }
              });
              $("#supervisor").select2("trigger", "select", {
                data: {
                  id: '',
                  text: ''
                }
              });
              $("#rublo").select2("trigger", "select", {
                data: {
                  id: '',
                  text: ''
                }
              });
            } else if (res == "oks") {
              alertify.success("Registros Guardados Correctamente (Sin Imagen)");
              $('#form_datos')[0].reset();
              cargar_tabla();
              // $("#id_proveedor").select2("trigger", "select", {
              //   data: { id: '', text:'' }
              // });
              $("#supervisor").select2("trigger", "select", {
                data: {
                  id: '',
                  text: ''
                }
              });
              $("#rublo").select2("trigger", "select", {
                data: {
                  id: '',
                  text: ''
                }
              });
              $("#id_sucursal").select2("trigger", "select", {
                data: {
                  id: '',
                  text: ''
                }
              });
            } else {
              alertify.error("Ha Ocurrido un Error");
            }
          });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $(document).ready(function() {
      $("#form_datos").validate({
        rules: {
          id_proveedor: "required",
          encargado: "required",
          fecha1: "required",
          supervisor: "required",
          rublo: "required",
          id_sucursal: "required"
        },
        messages: {
          id_proveedor: "Campo requerido",
          encargado: "Campo requerido",
          fecha1: "Campo requerido",
          supervisor: "Campo requerido",
          rublo: "Campo requerido",
          id_sucursal: "Campo requerido"
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
    $('.form_datetime').datetimepicker({
      //language:  'fr',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
      showMeridian: 1
    });
    $('.form_date').datetimepicker({
      language: 'es',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });
    $('.form_time').datetimepicker({
      language: 'fr',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 1,
      minView: 0,
      maxView: 1,
      forceParse: 0
    });
    $("#file-es").fileinput({
      language: 'es',
      browseClass: "btn btn-danger",
      fileType: "jpg",
      allowedFileExtensions: ['jpg', 'jpeg'],
      uploadUrl: 'guardar.php',
      uploadAsync: false,
      maxFileCount: 5,
      maxFileSize: 50000,
      showUpload: false,
      removeFromPreviewOnError: true
    });

    function editar(id) {
      $.ajax({
        url: 'editar_registro.php',
        data: '&id=' + id,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);

          $('#servicio_id').val(id);
          $("#id_proveedor").select2("trigger", "select", {
            data: {
              id: array[0],
              text: array[1]
            }
          });
          $('#encargado').val(array[2]);
          $('#fecha1').val(array[3]);
          $('#gasto').val(array[4]);
          $("#supervisor").select2("trigger", "select", {
            data: {
              id: array[5],
              text: array[6]
            }
          });
          $("#supervisor").select2("trigger", "select", {
            data: {
              id: array[5],
              text: array[6]
            }
          });
          $("#rublo").select2("trigger", "select", {
            data: {
              id: array[7],
              text: array[8]
            }
          });
          $('#comentario').val(array[9]);
          $("#id_sucursal").select2("trigger", "select", {
            data: {
              id: array[10],
              text: array[11]
            }
          });
        }
      });
    }

    function eliminar(id) {
      swal({
          title: "¿Está seguro de eliminar registro?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar_registro.php',
              data: '&id=' + id,
              type: "POST",
              success: function(respuesta) {
                if (respuesta = "ok") {
                  alertify.success("Registro Eliminado Correctamente");
                  cargar_tabla();
                } else {
                  alertify.error("Ha Ocurrido un Error");
                }
              }
            });
          }
        });
    }
  </script>
  <script>
    $(function() {
      $('#supervisor').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "combos_usuarios.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            equipo = $("#equipo").val();
            return {
              searchTerm: params.term,
              equipo: equipo // search term
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
      $('#id_proveedor').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "combo_proveedores.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term
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
      $('#rublo').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "consulta_rublos.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term
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
      $('#id_sucursal').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "consulta_sucursales.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term
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
    });

    function cargar_tabla_modal() {
      $('#lista_rublos').dataTable().fnDestroy();
      $('#lista_rublos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": true,
        "pageLength": 5,
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
            title: 'Lista Rublos',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Lista Rublos',
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
          "url": "tabla_rublos.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "Nombre"
          },
          {
            "data": "Editar"
          },
          {
            "data": "Eliminar"
          }
        ]
      });
    }
    $('#modal-default').on('show.bs.modal', function(e) {
      cargar_tabla_modal();
    });

    function guardar() {
      var url = "insertar_rublo.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $('#form_datos_rublo').serialize(),
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Registro Guardado Correctamente");
            $('#rublo_modal').val("");
            $('#id_registro_modal').val("0");
            cargar_tabla_modal();
          } else if (respuesta == "duplicado") {
            alertify.error("Registro Existente");
          } else {
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
      return false;
    }

    function eliminar_rublo(id) {
      swal({
          title: "¿Está seguro de eliminar registro?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar_registro2.php',
              data: '&id=' + id,
              type: "POST",
              success: function(respuesta) {
                if (respuesta = "ok") {
                  alertify.success("Registro Eliminado Correctamente");
                  cargar_tabla_modal();
                } else {
                  alertify.error("Ha Ocurrido un Error");
                }
              }
            });
          }
        });
    }

    function editar_rublo(id) {
      $.ajax({
        url: 'editar_registro2.php',
        data: '&id=' + id,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          nombre = array[0];

          $('#id_registro_modal').val(id);
          $('#rublo_modal').val(nombre);

        }
      });
    }
    $('#modal-default1').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      var url = "consulta_datos_modal.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#comentario_modal').html(respuesta);
        }
      });
    });
  </script>
</body>

</html>