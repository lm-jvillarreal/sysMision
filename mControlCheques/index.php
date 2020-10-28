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
              <h3 class="box-title">Control de Cheques | Registro</h3> <br><br>
              <h2 class="box-title">Datos del cheque</h2>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="banco">*Banco:</label>
                    <input type="hidden" name="id_registro" id="id_registro">
                    <select name="banco" id="banco" class="select2" style="width: 250px">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="terminacion">*Terminación:</label>
                    <input type="text" name="terminacion" id="terminacion" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="empresa">*Empresa:</label>
                    <input type="text" name="empresa" id="empresa" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Fecha de venta:</label>
                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_venta" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" id="fecha_venta" name="fecha_venta">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="autoriza">*Autoriza:</label>
                    <input type="text" name="autoriza" id="autoriza" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="beneficiario">*Beneficiario:</label>
                    <input type="text" name="beneficiario" id="beneficiario" class="form-control" onchange="duplicar();">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="monto">*Monto:</label>
                    <input type="text" name="monto" id="monto" class="form-control">
                  </div>
                </div>
              </div>
              <div class="box-header">
                <h2 class="box-title">Datos del cliente</h2>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="nombre">*Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="telefono">*Teléfono:</label>
                    <input type="text" name="telefono" id="telefono" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="direccion">*Dirección:</label>
                    <input type="text" name="direccion" id="direccion" class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
            </div>
          </div>
        </form>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Cheques</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_cheques" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%"> ID</th>
                        <th width="15%">Cliente</th>
                        <th width="15%">Teléfono</th>
                        <th width="15%">Dirección</th>
                        <th width="35%">Banco</th>
                        <th width="35%">Terminación</th>
                        <th width="35%">Empresa</th>
                        <th width="15%">Monto</th>
                        <th width="15%">Fecha</th>
                        <th width="15%">Autoriza</th>
                        <th width="15%">Beneficiario</th>
                        <th width="15%"></th>
                        <th width="15%"></th>
                        <th width="15%">Fecha</th>

                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Cliente</th>
                        <th width="35%">Teléfono</th>
                        <th width="15%">Dirección</th>
                        <th width="15%">Banco</th>
                        <th width="35%">Terminación</th>
                        <th width="35%">Empresa</th>
                        <th width="15%">Monto</th>
                        <th width="15%">Fecha</th>
                        <th width="15%">Autoriza</th>
                        <th width="15%">Beneficiario</th>
                        <th width="15%"></th>
                        <th width="15%"></th>
                        <th width="15%">Fecha</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.row -->
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
    $(function() {
      $('#banco').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "select_banco.php",
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
    });
    $(function() {
      $('#datetimepicker_inicio').datetimepicker();
      $('#datetimepicker_fin').datetimepicker();
    });

    $.validator.setDefaults({
      submitHandler: function() {
        var url = "insertar_registro.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
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
            $("#form_datos")[0].reset();
            cargar_tabla();
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $(document).ready(function() {
      $("#form_datos").validate({
        rules: {
          banco: "required",
          terminacion: "required",
          empresa: "required",
          fecha_venta: "required",
          autoriza: "required",
          beneficiario: "required",
          nombre: "required",
          direccion: "required",
          telefono: "required",
          monto: "required",
        },
        messages: {
          banco: "Campo requerido",
          terminacion: "Campo requerido",
          empresa: "Campo requerido",
          fecha_venta: "Campo Requerido",
          autoriza: "Campo Requerido",
          beneficiario: "Campo Requerido",
          nombre: "Campo Requerido",
          direccion: "Campo Requerido",
          telefono: "Campo Requerido",
          monto: "Campo Requerido",
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
    function editar(id) {
      var url = 'editar.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id: id
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#id_registro").val(array[0]);
          $("#banco").val(array[1]);
          $("#terminacion").val(array[2]);
          $("#empresa").val(array[3]);
          $("#fecha_venta").val(array[4]);
          $("#autoriza").val(array[5]);
          $("#beneficiario").val(array[6]);
          $("#monto").val(array[7]);
          $("#nombre").val(array[8]);
          $("#direccion").val(array[9]);
          $("#telefono").val(array[10]);
        },
      });
    }

    function duplicar() {
      var beneficiario = $("#beneficiario").val();
      $("#nombre").val(beneficiario);
    }

    function estatus(registro) {
      var id_registro = registro;
      var url = 'eliminar_registro.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Registro Eliminado Correctamente");
            cargar_tabla();
          }
        },
        error: function(xhr, status) {
          alert("error");
        },
      });
    }

    function cargar_tabla() {
      $('#lista_cheques').dataTable().fnDestroy();
      $('#lista_cheques').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "order": ["13", "ASC"],
        "columnDefs": [{
          "targets": [0, 13],
          "visible": false,
          "searchable": false
        }],
        buttons: [{
            extend: 'pageLength',
            text: 'Registros',
            className: 'btn btn-default'
          },
          {
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'Control Cheques',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Control Cheques',
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
            "data": "id"
          },
          {
            "data": "cliente"
          },
          {
            "data": "telefono"
          },
          {
            "data": "direccion"
          },
          {
            "data": "banco"
          },
          {
            "data": "terminacion"
          },
          {
            "data": "empresa"
          },
          {
            "data": "monto"
          },
          {
            "data": "fecha_venta"
          },
          {
            "data": "autoriza"
          },
          {
            "data": "beneficiario"
          },
          {
            "data": "editar"
          },
          {
            "data": "eliminar"
          },
          {
            "data": "fecha"
          },
        ]
      });
    }
    $(function() {
      cargar_tabla()
    })
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