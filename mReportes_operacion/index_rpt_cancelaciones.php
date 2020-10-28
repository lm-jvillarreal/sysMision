<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <script src="funciones.js"></script>
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
            <h3 class="box-title">Reportes | Cancelaciones p/cajero</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="frmDatos" action="rpt_analisis.php">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_inicio">*Fecha de inicio:</label>
                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial" name="fecha_inicial">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_fin">*Fecha final:</label>
                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="" readonly id="fecha_final" name="fecha_final">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="sucursal">*Sucursal:</label>
                    <select name="sucursal" onchange="cargar_cajeros()" id="sucursal" class="form-control select">
                      <option value=""></option>
                      <option value="1">Díaz Ordaz</option>
                      <option value="2">Arboledas</option>
                      <option value="3">Villegas</option>
                      <option value="4">Allende</option>
                      <option value="5">Petaca</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="sucursal">*Cajero:</label>
                    <select name="cajero" id="cajeros" class="form-control select2">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
          </div>
          <div class="box-footer text-right">
            <!-- <button class="btn btn-warning" id="mostrar_datos">Mostrar datos</button> -->


            <a href="javascript:consulta()" class="btn btn-danger">Consultar</a>
          </div>
          </form>
        </div>
        <div class="box box-danger">
          <div class="box box-body">
            <div id="contenedor_tabla"></div>
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
    function estilo_tablas() {
      $('#lista_modulos').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false,
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        }
      })
    }
    $(function() {
      estilo_tablas();
    })
    $.validator.setDefaults({
      submitHandler: function() {
        var url = "insertar_modulo.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "ok") {
              alertify.success("Registro guardado correctamente");
            } else if (respuesta == "duplicado") {
              alertify.error("El registro ya existe");
            } else {
              alertify.error("Ha ocurrido un error");
            }
            $(":text").val(''); //Limpiar los campos tipo Text
            $("#lista_modulos").destroy();
            $("#tabla").load("tabla_modulos.php");
            estilo_tablas();
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $(document).ready(function() {
      $("#form_datos").validate({
        rules: {
          nombre_modulo: "required",
          nombre_carpeta: "required",
          descripcion_modulo: "required"
        },
        messages: {
          nombre_modulo: "Campo requerido",
          nombre_carpeta: "Campo requerido",
          descripcion_modulo: "Campo requerido"
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
          $(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-3").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
        }
      });
    });
  </script>
  <script type="text/javascript">
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
  <script>
    $(function() {
      $('.select').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es'
      })
    })
  </script>
  <script type="text/javascript">
    function cargar_cajeros() {
      var sucursal = $('#sucursal').val();
      $('#cajeros').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "consulta_cajeros.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term,
              sucursal: sucursal // search term
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
    }

    function consulta() {
      //alert("Consultando, de clic en 'Aceptar' y espere...");
      $.ajax({
        url: "tabla_cancelaciones.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatos').serialize(),
        success: function(respuesta) {
          $('#contenedor_tabla').html(respuesta);
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }
  </script>
</body>

</html>