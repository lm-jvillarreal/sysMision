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
        <div class="box box-danger" <?php echo $solo_lectura?>>
          <div class="box-header">
            <h3 class="box-title">Registro UPS | Registro</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
            <input type="text" name="id_registro" id="id_registro" class="form-control hidden" value="0">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*No. Serie:</label>
                    <input type="text" name="no_serie" id="no_serie" class="form-control" placeholder="Numero de Serie">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Sucursal:</label>
                    <select name="id_sucursal" id="id_sucursal" class="form-control">
                        <option value="1">Diaz Ordaz</option>
                        <option value="2">Arboledas</option>
                        <option value="3">Villegas</option>
                        <option value="4">Allende</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Ubicación:</label>
                    <input type="text" name="ubicacion" id="ubicacion" class="form-control" placeholder="Ubicación del Equipo">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Marca:</label>
                    <input type="text" name="marca" id="marca" class="form-control" placeholder="Marca del UPS">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Modelo:</label>
                    <input type="text" name="modelo" id="modelo" class="form-control" placeholder="Modelo del UPS">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Tipo:</label>
                    <input type="text" name="tipo" id="tipo" class="form-control" placeholder="Tipo de UPS">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Capacidad:</label>
                    <input type="text" name="capacidad" id="capacidad" class="form-control" placeholder="Capacidad de UPS">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Entrada / Salida de CA Nominal:</label>
                    <input type="text" name="entrada_salida" id="entrada_salida" class="form-control" placeholder="Entrada / Salida de CA Nominal">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Tomacorrientes:</label>
                    <input type="text" name="tomacorrientes" id="tomacorrientes" class="form-control" placeholder="Tomacorrientes">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Tiempo de Respaldo:</label>
                    <input type="text" name="tiempo_respaldo" id="tiempo_respaldo" class="form-control" placeholder="Tiempo de Respaldo">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Garantía:</label>
                    <input type="text" name="garantia" id="garantia" class="form-control" placeholder="Garantia del UPS">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Series:</label>
                    <input type="text" name="series" id="series" class="form-control" placeholder="Serie">
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="box box-danger" id="tabla_principal">
          <div class="box-header">
            <h3 class="box-title">Proveedores Mantenimiento | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_ups" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>No Serie</th>
                        <th>Sucursal</th>
                        <th>Ubicacion</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Tipo</th>
                        <th>Capacidad</th>
                        <th>EntradaSalida</th>
                        <th>TomaCorr</th>
                        <th>T.Respaldo</th>
                        <th>Garantia</th>
                        <th>Series</th>
                        <th>Acciones</th>
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

<?php include '../footer.php';?>
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
      $('#lista_ups').dataTable().fnDestroy();
      $('#lista_ups').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
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
          "url": "tabla_ups.php",
          "dataSrc": ""
        },
        "columns": [
          { "data": "#", "width":"3%" },
          { "data": "NoSerie"},
          { "data": "Sucursal" },
          { "data": "Ubicacion"},
          { "data": "Marca"},
          { "data": "Modelo"},
          { "data": "Tipo"},
          { "data": "Capacidad"},
          { "data": "EntradaSalida"},
          { "data": "TomaCorr"},
          { "data": "TR"},
          { "data": "Garantia"},
          { "data": "Series"},
          { "data": "Acciones", "width":"15%"}
        ]
      });
  }
  cargar_tabla();
  $.validator.setDefaults( {
    submitHandler: function () {
      $.ajax({
        type: "POST",
        url: 'guardar_ups.php',
        data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta=="ok") {
            alertify.success("Registro guardado correctamente");
            $('#form_datos')[0].reset();
            cargar_tabla();
            cargar();
          }else if(respuesta=="duplicado"){
            alertify.error("El registro ya existe");
          }else if(respuesta=="vacio"){
            alertify.error("Verifica Campos");
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
        no_serie: "required",
        id_sucursal: "required",
        ubicacion: "required",
        marca: "required",
        modelo: "required",
        tipo: "required",
        capacidad: "required",
        entrada_salida: "required",
        tomacorrientes: "required",
        tiempo_respaldo: "required",
        garantia: "required",
        series: "required"
      },
      messages: {
        no_serie: "Campo requerido",
        id_sucursal: "Campo requerido",
        ubicacion: "Campo requerido",
        marca: "Campo requerido",
        modelo: "Campo requerido",
        tipo: "Campo requerido",
        capacidad: "Campo requerido",
        entrada_salida: "Campo requerido",
        tomacorrientes: "Campo requerido",
        tiempo_respaldo: "Campo requerido",
        garantia: "Campo requerido",
        series: "Campo requerido"
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
  function eliminar(id){
    swal({
      title: "¿Está Seguro de Eliminar Registro?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_ups.php',
          data: {'id':id} ,
          type: "POST",
          success: function(respuesta) {
            if(respuesta == "ok"){
              alertify.success('Registro Eliminado');
              cargar_tabla();
            }
            else{
              alertify.error('Ha Ocurrido un Error');
            }
            }
        });
      }
    });
  }
  function cargar(){
    var id = 1;
      $.ajax({
        url: 'cargar_ultimo.php',
        data: {'id':id},
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_sucursal').val(array[0]).trigger('change.select2');
          $('#marca').val(array[1]);
          $('#modelo').val(array[2]);
          $('#tipo').val(array[3]);
          $('#capacidad').val(array[4]);
          $('#entrada_salida').val(array[5]);
          $('#tomacorrientes').val(array[6]);
          $('#tiempo_respaldo').val(array[7]);
          $('#garantia').val(array[8]);
          $('#series').val(array[9]);
        }
      });
  }
  function editar(id){
      $.ajax({
        url: 'editar_ups.php',
        data: {'id':id},
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_registro').val(id);
          $('#id_sucursal').val(array[0]).trigger('change.select2');
          $('#marca').val(array[1]);
          $('#modelo').val(array[2]);
          $('#tipo').val(array[3]);
          $('#capacidad').val(array[4]);
          $('#entrada_salida').val(array[5]);
          $('#tomacorrientes').val(array[6]);
          $('#tiempo_respaldo').val(array[7]);
          $('#garantia').val(array[8]);
          $('#series').val(array[9]);
          $('#ubicacion').val(array[10]);
          $('#no_serie').val(array[11]);
        }
      });
  }
  cargar();
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
