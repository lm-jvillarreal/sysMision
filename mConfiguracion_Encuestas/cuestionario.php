<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha = date('Y-m-d');
  $hora  = date('h:i:s');
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
    <?php include 'menuV2.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Creacion de Cuestionario</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="pregunta">*Nombre</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de Cuestionario">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha inicio:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_inicio" name="fecha_inicio">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_fin">*Fecha Final:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha?>" readonly id="fecha_fin" name="fecha_fin">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Preguntas</label>
                  <select name="preguntas[]" id="preguntas" class="select2" multiple style="width: 100%"></select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>*Limite Encuestados</label>
                  <input type="text" name="cantidad" id="cantidad" class="form-control">
                </div>
              </div>
              <div class="col-md-4">
                <label for="sucursal">*Sucursal</label>
                <select name="sucursal[]" id="sucursal" class="select2" multiple style="width: 100%"></select>
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
            <h3 class="box-title">Lista de Cuestionarios Existentes</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="lista_cuestionarios" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th width="5%">#</th>
                    <th width="30%">Nombre</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Cant. de Preguntas</th>
                    <th>Encuestados Restantes</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                    <th>Ver</th>
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
                    <th></th>
                  </tr>
                </tbody>  
              </table>
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
  function cargar_tabla_cuestionarios(){
    $('#lista_cuestionarios').dataTable().fnDestroy();
    $('#lista_cuestionarios').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
        "type": "POST",
        "url": "tabla_cuestionarios.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Fecha Inicio" },
        { "data": "Fecha Fin" },
        { "data": "Cantidad de Preguntas" },
        { "data": "Cantidad de Encuestados" },
        { "data": "Editar" },
        { "data": "Eliminar" },
        { "data": "Ver" },
      ]
   });
  } 
  $(function (){
   cargar_tabla_cuestionarios();
  })
    $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar_cuestionario.php"; // El script a dónde se realizará la petición.
          $.ajax({
             type: "POST",
             url: url,
             data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
             success: function(respuesta)
             {
              if (respuesta=="ok") {
                alertify.success("Cuestionario Guardado correctamente");
                $('#nombre').val(''); //Limpiar los campos tipo Text
                $('#cantidad').val(''); //Limpiar los campos tipo Text
                llenar_combo_preguntas();
                cargar_tabla_cuestionarios();
                llenar_combo_sucursales();
              }else if(respuesta=="duplicado"){
                alertify.error("La pregunta ya existe");
              }else {
                alertify.error("Ha ocurrido un error");
              }
             }
           });
          // Evitar ejecutar el submit del formulario.
          return false;
      }
    });
    $( document ).ready( function () {
      $( "#form_datos" ).validate( {
        rules: {
          nombre: "required",
          fecha_inicio: "required",
          fecha_fin: "required",
          preguntas: "required",
          cantidad: "required",
        },
        messages: {
          nombre: "Campo requerido",
          fecha_inicio: "Campo requerido",
          fecha_fin: "Campo requerido",
          preguntas: "Campo requerido",
          cantidad: "Campo requerido",
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
          // Add the `help-block` class to the error element
          error.addClass( "help-block" );

          if ( element.prop( "type" ) === "checkbox" ) {
            error.insertAfter( element.parent( "label" ) );
          } else {
            error.insertAfter( element );
          }
        },
        highlight: function ( element, errorClass, validClass ) {
          $( element ).parents( ".col-md-3" ).addClass( "has-error" ).removeClass( "has-success" );
          $( element ).parents( ".col-md-4" ).addClass( "has-error" ).removeClass( "has-success" );
          $( element ).parents( ".col-md-6" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
          $( element ).parents( ".col-md-3" ).addClass( "has-success" ).removeClass( "has-error" );
          $( element ).parents( ".col-md-4" ).addClass( "has-success" ).removeClass( "has-error" );
          $( element ).parents( ".col-md-6" ).addClass( "has-success" ).removeClass( "has-error" );
        }
      });
    });
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  });
  function llenar_combo_preguntas() {
    $.ajax({
      type: "POST",
      url: "combo_preguntas.php",
      success: function(response)
      { 
        $('#preguntas').html(response).fadeIn();
      }
    });
  }
  llenar_combo_preguntas();
  function llenar_combo_sucursales() {
    $.ajax({
      type: "POST",
      url: "combo_sucursales.php",
      success: function(response)
      { 
        $('#sucursal').html(response).fadeIn();
      }
    });
  }
  llenar_combo_sucursales();
  function eliminar(folio){
      swal({
          title: "¿Está seguro de eliminar Cuestionario?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
      .then((willDelete) => {
        if (willDelete) {
          swal("El cuestionario se ha eliminado.", {
            icon: "success",
          });
          $.ajax({
            url: 'eliminar_cuestionario.php',
            data: '&folio='+ folio ,
            type: "POST",
            success: function(respuesta) {
              if(respuesta == "ok"){
                cargar_tabla_cuestionarios();
              }
              else{
                alertify.error('Ha Ocurrido un Error');
              }
             }
          });
        } else {
          swal("No se ha eliminado el cuestionario.",{
            icon: "error",
          });
        }
      });
  }
</script>
<script type="text/javascript">
  $('.form_datetime').datetimepicker({
      //language:  'fr',
      weekStart: 1,
      todayBtn:  1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
      showMeridian: 1
  });
  $('.form_date').datetimepicker({
      language:  'es',
      weekStart: 1,
      todayBtn:  1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
  });
  $('.form_time').datetimepicker({
      language:  'fr',
      weekStart: 1,
      todayBtn:  1,
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