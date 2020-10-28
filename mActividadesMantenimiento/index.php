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
          <div class="box box-danger" <?php echo $solo_lectura ?>>
            <div class="box-header">
              <h3 class="box-title">Actividades Diarias | Registro</h3>
            </div>
            <div class="box-body">
              <input type="text" name="id_registro" id="id_registro" class="form-control hidden" value="0">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="llave_banorte">*Fecha</label>
                    <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha" name="fecha" onchange="cargar_tabla(1)">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Sucursal:</label>
                    <select name="id_sucursal" id="id_sucursal" style="width: 100%"></select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Area:</label>
                    <select name="id_area" id="id_area" style="width: 100%"></select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Tipo de Actividad:</label>
                    <select name="tipo_actividad" id="tipo_actividad" style="width: 100%"></select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label>*Piezas:</label>
                    <select name="id_pieza[]" id="id_pieza" style="width: 100%" multiple></select>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label>*Compañeros:</label>
                    <select name="id_compañero[]" id="id_compañero" style="width: 100%" multiple></select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>*Tiempo Tardado:</label>
                    <input type="text" name="tiempo" id="tiempo" class="form-control">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>*Detalle de Actividad:</label>
                    <input type="text" name="dactividad" id="dactividad" class="form-control" placeholder="Detalle de Actividad">
                  </div>
                </div>
              </div>

            </div>
            <div class="box-footer text-right">
              <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
            </div>
          </div>
        </form>
        <div class="row" style="display: none" id="tablas_otras">
          <div class="col-md-6">
            <div class="box box-danger" id="tabla1">
              <div class="box-header">
                <h3 class="box-title">Piezas | Lista</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="tabla">
                    <div class="table-responsive">
                      <table id="lista_piezas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Eliminar</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-danger" id="tabla2">
              <div class="box-header">
                <h3 class="box-title">Compañeros | Lista</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="tabla">
                    <div class="table-responsive">
                      <table id="lista_compañeros" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Eliminar</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger" id="tabla_principal">
          <div class="box-header">
            <h3 class="box-title">Actividades Diarias | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_reportes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='3%'>#</th>
                        <th>Actividad</th>
                        <th width='10%'>Fecha</th>
                        <th width='5%'>Tipo Act.</th>
                        <th width='5%'>Tiempo</th>
                        <th width='10%'>Area</th>
                        <th width='5%'>Sucursal</th>
                        <th width='10%'>Piezas</th>
                        <th width='10%'>Compañeros</th>
                        <th width='3%'></th>
                        <th width='3%'></th>
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
    $('#tiempo').inputmask('99:99');
    $('#id_pieza').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_piezas.php",
        type: "POST",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          var id_caja = $('#id_caja').val();
          return {
            searchTerm: params.term, // search term
            id_caja: id_caja
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
    $('#id_area').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_areas.php",
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
    $('#id_sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_sucursales.php",
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
    $('#id_compañero').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_usuarios.php",
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
    $('#tipo_actividad').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_tipos.php",
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

    function cargar_tabla(validar) {
      var fecha = $("#fecha").val();
      $('#lista_reportes').dataTable().fnDestroy();
      $('#lista_reportes').DataTable({
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
          "url": "tabla.php",
          "dataSrc": "",
          "data": {
            fecha: fecha,
            validar: validar
          }
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "Actividad"
          },
          {
            "data": "fecha"
          },
          {
            "data": "Tiempo"
          },
          {
            "data": "TipoAct"
          },
          {
            "data": "Area"
          },
          {
            "data": "Sucursal"
          },
          {
            "data": "Piezas"
          },
          {
            "data": "Compañeros"
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
    cargar_tabla(0);

    function cargar_tabla1() {
      var id = $('#id_registro').val();
      $('#lista_piezas').dataTable().fnDestroy();
      $('#lista_piezas').DataTable({
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
          "url": "tabla1.php",
          "dataSrc": "",
          "data": {
            'id': id
          },
        },
        "columns": [{
            "data": "#",
            "width": "3%"
          },
          {
            "data": "Nombre"
          },
          {
            "data": "Eliminar",
            "width": "3%"
          }
        ]
      });
    }

    function cargar_tabla2() {
      var id = $('#id_registro').val();
      $('#lista_compañeros').dataTable().fnDestroy();
      $('#lista_compañeros').DataTable({
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
          "url": "tabla2.php",
          "dataSrc": "",
          "data": {
            'id': id
          },
        },
        "columns": [{
            "data": "#",
            "width": "3%"
          },
          {
            "data": "Nombre"
          },
          {
            "data": "Eliminar",
            "width": "3%"
          }
        ]
      });
    }
    $.validator.setDefaults({
      submitHandler: function() {
        $.ajax({
          type: "POST",
          url: 'guardar.php',
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "ok") {
              alertify.success("Registro guardado correctamente");
              $('#form_datos')[0].reset();
              cargar_tabla(1);
              $("#id_pieza").select2("trigger", "select", {
                data: {
                  id: '',
                  text: ''
                }
              });
              $("#id_area").select2("trigger", "select", {
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
              $("#id_pieza").val('').trigger('change');
              $("#id_compañero").val('').trigger('change');
              $('#descripcion').val("");
              $('#tabla_principal').show();
              $('#tablas_otras').hide();
            } else if (respuesta == "duplicado") {
              alertify.error("El registro ya existe");
            } else if (respuesta == "vacio") {
              alertify.error("Verifica Campos");
            } else {
              alertify.error("Ha ocurrido un error");
            }
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $(document).ready(function() {
      $("#form_datos").validate({
        rules: {
          fecha: "required",
          id_sucursal: "required",
          id_area: "required",
          tipo_actividad: "required",
          tiempo: "required",
          dactividad: "required"
        },
        messages: {
          fecha: "Campo requerido",
          id_sucursal: "Campo requerido",
          id_area: "Campo requerido",
          tipo_actividad: "Campo requerido",
          tiempo: "Campo requerido",
          dactividad: "Campo requerido",
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

    function eliminar(id) {
      swal({
          title: "¿Está Seguro de Eliminar Reporte?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar.php',
              data: {
                'id': id
              },
              type: "POST",
              success: function(respuesta) {
                if (respuesta == "ok") {
                  alertify.success('Registro Eliminado');
                  cargar_tabla(1);
                } else {
                  alertify.error('Ha Ocurrido un Error');
                }
              }
            });
          }
        });
    }

    function eliminar_pieza(id) {
      swal({
          title: "¿Está Seguro de Eliminar Pieza?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar_pieza.php',
              data: {
                'id': id
              },
              type: "POST",
              success: function(respuesta) {
                if (respuesta == "ok") {
                  alertify.success('Registro Eliminado');
                  cargar_tabla1();
                } else {
                  alertify.error('Ha Ocurrido un Error');
                }
              }
            });
          }
        });
    }

    function eliminar_compañero(id) {
      swal({
          title: "¿Está Seguro de Eliminar Compañero?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar_compañero.php',
              data: {
                'id': id
              },
              type: "POST",
              success: function(respuesta) {
                if (respuesta == "ok") {
                  alertify.success('Registro Eliminado');
                  cargar_tabla2();
                } else {
                  alertify.error('Ha Ocurrido un Error');
                }
              }
            });
          }
        });
    }

    function editar(id) {
      $.ajax({
        url: 'editar.php',
        data: {
          'id': id
        },
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_registro').val(id);
          $('#fecha').val(array[0]);
          $("#id_area").select2("trigger", "select", {
            data: {
              id: array[1],
              text: array[2]
            }
          });
          $("#id_sucursal").select2("trigger", "select", {
            data: {
              id: array[3],
              text: array[4]
            }
          });
          $("#tipo_actividad").select2("trigger", "select", {
            data: {
              id: array[5],
              text: array[6]
            }
          });
          $('#tiempo').val(array[7]);
          $('#dactividad').val(array[8]);
          $('#tabla_principal').hide();
          cargar_tabla1();
          cargar_tabla2();
          $('#tablas_otras').show();
        }
      });
    }
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
  </script>
</body>

</html>