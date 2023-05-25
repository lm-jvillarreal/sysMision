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
        <div class="box box-danger" <?php echo $solo_lectura ?>>
          <div class="box-header">
            <h3 class="box-title">Traspasos | Registro</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <input type="text" name="id_registro" id="id_registro" class="form-control hidden" value="0">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Sucursal Origen:</label>
                    <select name="id_sucursal" id="id_sucursal" class="form-control" style="width:100%"></select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Pieza:</label>
                    <select name="pieza" id="pieza" class="form-control" style="width:100%"></select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Sucursal Destino:</label>
                    <select name="id_sucursal2" id="id_sucursal2" class="form-control" style="width:100%"></select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Cantidad:</label>
                    <input type="text" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad de Piezas">
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button type="submit" class="btn btn-warning" id="guardar" disabled>Guardar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="box box-danger" id="tabla2">
          <div class="box-header">
            <h3 class="box-title">Traspasos | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_traspasos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Sucursal O.</th>
                        <th>Pieza</th>
                        <th>Sucursal D.</th>
                        <th>Cantidad</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tbody>
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
    $('#id_sucursal2').select2({
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
    $('#pieza').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_catalogo.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term,
            id_sucursal: $('#id_sucursal').val()
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
    $('#pieza').change(function() {
      var id_pieza = this.value;
      $.ajax({
        url: 'consulta.php',
        data: {
          'id_pieza': id_pieza
        },
        type: "POST",
        success: function(respuesta) {
          $('#cantidad').attr('placeholder', respuesta);
        }
      });
    })
    $('#cantidad').keyup(function() {
      var limite = document.querySelector('#cantidad');
      var valor = $('#cantidad').val();
      if (valor == 0) {
        $('#guardar').prop('disabled', true);
      } else if (valor > limite.placeholder) {
        alertify.error("No Tienes Piezas Suficientes");
        $('#guardar').prop('disabled', true);
      } else {
        $('#guardar').prop('disabled', false);
      }
    })

    function cargar_tabla() {
      $('#lista_traspasos').dataTable().fnDestroy();
      $('#lista_traspasos').DataTable({
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
          "dataSrc": ""
        },
        "columns": [{
            "data": "#",
            "width": "3%"
          },
          {
            "data": "SucursalO",
            "width": "3%"
          },
          {
            "data": "Pieza"
          },
          {
            "data": "SucursalD",
            "width": "3%"
          },
          {
            "data": "Cantidad",
            "width": "3%"
          },
          {
            "data": "Editar",
            "width": "3%"
          },
          {
            "data": "Eliminar",
            "width": "3%"
          }
        ]
      });
    }
    cargar_tabla();
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
              $("#id_sucursal").select2("trigger", "select", {
                data: {
                  id: '',
                  text: ''
                }
              });
              $("#id_sucursal2").select2("trigger", "select", {
                data: {
                  id: '',
                  text: ''
                }
              });
              $("#pieza").select2("trigger", "select", {
                data: {
                  id: '',
                  text: ''
                }
              });
              cargar_tabla();
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
          id_sucursal: "required",
          pieza: "required",
          id_sucursal2: "required",
          cantidad: "required"
        },
        messages: {
          id_sucursal: "Campo requerido",
          pieza: "Campo requerido",
          id_sucursal2: "Campo requerido",
          cantidad: "Campo requerido"
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
          title: "¿Está Seguro de Eliminar Registro?",
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
                  cargar_tabla();
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
          $("#id_sucursal").select2("trigger", "select", {
            data: {
              id: array[0],
              text: array[1]
            }
          });
          $("#id_sucursal2").select2("trigger", "select", {
            data: {
              id: array[2],
              text: array[3]
            }
          });
          $("#pieza").select2("trigger", "select", {
            data: {
              id: array[4],
              text: array[5]
            }
          });
          $('#cantidad').val(array[6]);
        }
      });
    }
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
  </script>
</body>

</html>