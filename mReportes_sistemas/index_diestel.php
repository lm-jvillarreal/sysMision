<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$qry = "SELECT * FROM comentarios_reportes";
$exQry = mysqli_query($conexion, $qry);
$row = mysqli_fetch_row($exQry);
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
            <h3 class="box-title">Reportes | Diestel</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datoss" action="reportes/rpt_recargas_2.php">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_inicio">*Fecha de inicio:</label>
                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial" name="fecha_inicial" form="frmDatosRef">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_fin">*Fecha final:</label>
                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="" readonly id="fecha_final" name="fecha_final" form="frmDatosRef">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <label>Comentarios</label>
                  <input value="<?php echo $row[1] ?>" type="text" onblur="insertar_comentarios_diestel($(this).val())" class="form-control">
                </div>
              </div>
          </div>
          <div class="box-footer text-right">
            <a href="javascript:guardar()" class="btn btn-danger">Guardar</a>
            <input type="submit" value="Generar Excel" class="btn btn-danger">
            <a href="javascript:cargar_datos()" class="btn btn-danger">Mostrar Datos</a>
          </div>
          </form>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Datos</h3>
          </div>
          <div class="box-body">
            <form id="frmDatosRef">
              <div class="row">
                <div class="col-md-3">
                  <label>Referencia</label>
                  <input type="text" class="form-control" name="referencia">
                  <input type="hidden" name="tipo" value="2">
                </div>
              </div>
              <div class="table-responsive">
                <table id="datos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">Codigo</th>
                      <th>Descripcion</th>
                      <th width="5%">DO</th>
                      <th width="5%">Arb</th>
                      <th width="5%">Vill</th>
                      <th width="5%">All</th>
                      <th width="5%">Pet</th>
                      <th width="5%">Total</th>
                      <th width="10%">Cap</th>
                      <th width="5%">Dif</th>
                    </tr>
                  </thead>
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
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <?php include '../footer.php'; ?>
  <!-- Page script -->
  <script>
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

    function insertar_comentarios_diestel(comentario) {
      var tipo = 1;
      $.ajax({
        data: {
          'comentario': comentario,
          'tipo': tipo
        }, //datos que se envian a traves de ajax
        url: 'comentarios.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {}
      });
    }

    function guardar() {
      //alert(comentario);
      var tipo = 2;
      $.ajax({
        data: $('#frmDatosRef').serialize(), //datos que se envian a traves de ajax
        url: 'totales_renglon.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
          // alert("Información guardada");
          location.reload();
        }
      });
    }

    function copiar(numero) {
      var total = $('#total' + numero).val();
      $('#cap' + numero).val(total);
    }

    function diferencia(numero) {
      var total = $('#total' + numero).val();
      var capturado = $('#cap' + numero).val();

      var resultado = total - capturado;
      $('#dif' + numero).html(resultado);
      $('#dif1' + numero).val(resultado);
    }

    function cargar_datos() {
      var fecha_inicial = $("#fecha_inicial").val();
      var fecha_final = $("#fecha_final").val();
      $('#datos').dataTable().fnDestroy();
      $('#datos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_diestel.php",
          "dataSrc": "",
          "data": {
            fecha_inicial: fecha_inicial,
            fecha_final: fecha_final
          }
        },
        "columns": [{
            "data": "codigo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "do"
          },
          {
            "data": "arb"
          },
          {
            "data": "vil"
          },
          {
            "data": "all"
          },
          {
            "data": "pet"
          },
          {
            "data": "total"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "dif"
          }
        ]
      });
    };
  </script>
</body>

</html>