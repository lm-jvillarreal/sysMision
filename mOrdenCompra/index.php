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
            <h3 class="box-title">Orden de Compra | Registro</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <input type="text" name="id_registro" id="id_registro" class="form-control hidden" value="0">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Proveedor:</label>
                    <select name="id_proveedor" id="id_proveedor" class="form-control" style="width:100%"></select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Vendedor:</label>
                    <input type="text" name="vendedor" id="vendedor" class="form-control" placeholder="Razón Social" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Telefono:</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Telefono de Empresa" readonly>
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
              </div>
            </form>
            <form method="POST" id="form_datos2" style="display: none;">
              <input type="text" name="folio" id="folio" class="form-control hidden">
              <input type="text" name="id_registro2" id="id_registro2" class="form-control hidden" value="0">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Cantidad:</label>
                    <input type="text" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad" onkeyup="calcular()">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Concepto:</label>
                    <input type="text" name="concepto" id="concepto" class="form-control" placeholder="Concepto">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Costo:</label>
                    <div class="input-group">
                      <div class="input-group-addon">$</div>
                      <input type="text" name="costo" class="form-control" id="costo" placeholder="Costo" onkeyup="calcular();">
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Importe:</label>
                    <div class="input-group">
                      <div class="input-group-addon">$</div>
                      <input type="text" name="importe" id="importe" class="form-control" placeholder="Importe" readonly>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button type="button" class="btn btn-warning" id="guardar_detalle">Guardar Detalle</button>
                <button type="button" class="btn btn-danger" id="terminar">Terminar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="box box-danger" id="tabla_principal">
          <div class="box-header">
            <h3 class="box-title">Orden de Compra | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_ordenes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Proveedor</th>
                        <th>Vendedor</th>
                        <th>Telefono</th>
                        <th>Fecha</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        <th>PDF</th>
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
                        <th></th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger" id="tabla2" style="display: none;">
          <div class="box-header">
            <h3 class="box-title">Orden de Compra | Detalle</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_detalle" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Cantidad</th>
                        <th>Concepto</th>
                        <th>Costo</th>
                        <th>Importe</th>
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
    $('#terminar').click(function() {
      $('#tabla_principal').show();
      $('#form_datos').show();
      $('#form_datos2').hide();
      $('#tabla2').hide();
      $('#form_datos2')[0].reset();
      $('#form_datos')[0].reset();
      $("#id_proveedor").select2("trigger", "select", {
        data: {
          id: '',
          text: ''
        }
      });
    })
    $('#guardar_detalle').click(function() {
      $.ajax({
        type: "POST",
        url: 'guardar_detalle.php',
        data: $("#form_datos2").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Registro guardado correctamente");
            cargar_tabla2();
            $('#cantidad').val("");
            $('#concepto').val("");
            $('#costo').val("");
            $('#importe').val("");
            $('#id_registro2').val("0");
          } else {
            alertify.error("Ha ocurrido un error");
          }
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
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
    $('#id_proveedor').change(function() {
      var id_proveedor = this.value;
      $.ajax({
        type: "POST",
        url: 'consultar_datos.php',
        data: {
          'id_proveedor': id_proveedor
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#vendedor').val(array[0]);
          $('#telefono').val(array[1]);
        }
      });
    })

    function cargar_tabla() {
      $('#lista_ordenes').dataTable().fnDestroy();
      $('#lista_ordenes').DataTable({
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
            "data": "Proveedor"
          },
          {
            "data": "Vendedor"
          },
          {
            "data": "Telefono"
          },
          {
            "data": "Fecha"
          },
          {
            "data": "Editar",
            "width": "3%"
          },
          {
            "data": "Eliminar",
            "width": "3%"
          },
          {
            "data": "PDF",
            "width": "3%"
          }
        ]
      });
    }

    function cargar_tabla2() {
      var folio = $('#folio').val();
      $('#lista_detalle').dataTable().fnDestroy();
      $('#lista_detalle').DataTable({
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
            folio: folio
          },
        },
        "columns": [{
            "data": "#",
            "width": "3%"
          },
          {
            "data": "Cantidad",
            "width": "3%"
          },
          {
            "data": "Concepto"
          },
          {
            "data": "Costo",
            "width": "3%"
          },
          {
            "data": "Importe",
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

    function calcular() {
      var costo = parseFloat($('#costo').val());
      var cantidad = parseFloat($('#cantidad').val());
      var total = costo * cantidad;
      $('#importe').val(total);
    }
    cargar_tabla();
    $.validator.setDefaults({
      submitHandler: function() {
        $.ajax({
          type: "POST",
          url: 'guardar.php',
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            var array = eval(respuesta);
            if (array[0] == "ok" && array[1] != 0) {
              alertify.success("Registro guardado correctamente");
              $('#form_datos')[0].reset();
              $("#id_proveedor").select2("trigger", "select", {
                data: {
                  id: '',
                  text: ''
                }
              });
              $('#folio').val(array[1]);
              cargar_tabla();
              $('#tabla_principal').hide();
              $('#form_datos').hide();
              $('#form_datos2').show();
              $('#tabla2').show();
              cargar_tabla2();
            } else if (array[0] == "ok" && array[1] == 0) {
              alertify.success("Registro Actualizado correctamente");
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
          id_proveedor: "required",
          vendedor: "required",
          telefono: "required"
        },
        messages: {
          id_proveedor: "Campo requerido",
          vendedor: "Campo requerido",
          telefono: "Campo requerido"
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
          $("#id_proveedor").select2("trigger", "select", {
            data: {
              id: array[0],
              text: array[1]
            }
          });
          $('#vendedor').val(array[2]);
          $('#telefono').val(array[3]);
          $('#folio').val(array[4]);
          $('#tabla2').show();
          cargar_tabla2(array[4]);
          $('#tabla_principal').hide();
          $('#form_datos2').show();
          $('#tabla2').show();
        }
      });
    }

    function editar_detalle(id) {
      $.ajax({
        url: 'editar_detalle.php',
        data: {
          'id': id
        },
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_registro2').val(id);
          $('#cantidad').val(array[1]);
          $('#concepto').val(array[0]);
          $('#costo').val(array[2]);
          $('#importe').val(array[3]);
        }
      });
    }

    function eliminar_detalle(id) {
      swal({
          title: "¿Está Seguro de Eliminar Registro?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar_detalle.php',
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