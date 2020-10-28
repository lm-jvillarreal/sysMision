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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Tiempo Extra | Reportes</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datoss" action="http://200.1.1.197/SMPruebas/mReporteTiempoExtra/generar_lista.php">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_uno">*Fecha de inicio:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_uno" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly id="fecha_uno" name="fecha_uno">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_dos">*Fecha final:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_dos" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly id="fecha_dos" name="fecha_dos">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="sucursal">*Sucursal:</label>
                  <select name="sucursal" id="sucursal" class="form-control select2">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
          <a class="btn btn-warning" onclick="verificar($('#fecha_uno').val(),$('#fecha_dos').val(),$('#sucursal').val());">Generar Tabla</a>
            <input type="submit" value="Generar Excel" class="btn btn-danger">
          </div>
          </form>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Tiempo Extra | Desglose</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_tiempo_extra" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                      <th> ID</th>
                        <th>Empleado</th>
                        <th>Departamento</th>
                        <th>Sucursal</th>
                        <th>Motivo</th>
                        <th>Autoriza</th>
                        <th>Tiempo Generado</th> 
                        <th>Comentario</th>
                        <th>Fecha</th>
                        <th>Fecha Registro</th>
                        <th>Hora Inicio</th>
                        <th>Hora Final</th>

                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                      <th> ID</th>
                        <th>Empleado</th>
                        <th>Departamento</th>
                        <th>Sucursal</th>
                        <th>Motivo</th>
                        <th>Autoriza</th>
                        <th>Tiempo Generado</th> 
                        <th>Comentario</th>
                        <th>Fecha</th>
                        <th>Fecha Registro</th>
                        <th>Hora Inicio</th>
                        <th>Hora Final</th>
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
<!-- Page script -->
<script>
  function estilo_tablas () {
    $('#lista_modulos').DataTable({
      'paging'    : true,
      'lengthChange'  : true,
      'searching'   : true,
      'ordering'    : true,
      'info'      : true,
      'autoWidth'   : false,
      'language'    : {"url": "../plugins/DataTables/Spanish.json"}
    })
   }  
  $(function (){
   estilo_tablas();
  })
    $(function () {
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: "combo_sucursal.php",
     type: "post",
     dataType: 'json',
     delay: 250,
     data: function (params) {
      return {
        searchTerm: params.term // search term
      };
     },
     processResults: function (response) {
       return {
          results: response
       };
     },
     cache: true
    }
    })
  });
  function verificar(fecha_uno,fecha_dos, sucursal) {
    if(fecha_uno == "" || fecha_dos == "")
    {
      alertify.error("Verifica Campos",2);
    }
    else
    {
      if (fecha_uno > fecha_dos)
      {
        alertify.error("Fecha Inicio es Mayor",2);
      }
      else
      {
        cargar_tabla(fecha_uno,fecha_dos, sucursal);
        
      }
    }
  }
  function cargar_tabla(fecha_uno,fecha_dos, sucursal) {
    $('#lista_tiempo_extra').dataTable().fnDestroy();
    $('#lista_tiempo_extra').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "lengthMenu": [[-1], ["All"]],
        "ajax": {
            "type": "POST",
            "url": "http://200.1.1.197/SMPruebas/mReporteTiempoExtra/tabla_otros.php",
            "dataSrc": "",
            "data":{'fecha_uno':fecha_uno,'fecha_dos':fecha_dos, 'sucursal':sucursal}
        },
        "columns": [
            { "data": "id" },
            { "data": "nombre" },
            { "data": "departamento" },
            { "data": "sucursal" },
            { "data": "motivo" },
            { "data": "autoriza" },
            { "data": "tiempo" },
            { "data": "comentario" },
            { "data": "fecha" },
            { "data": "fechaDos" },
            { "data": "horaInicio" },
            { "data": "horaFinal" }
        ]
    } );
  }
    $( document ).ready( function () {
      $( "#form_datos" ).validate( {
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
          $( element ).parents( ".col-md-6" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
          $( element ).parents( ".col-md-3" ).addClass( "has-success" ).removeClass( "has-error" );
          $( element ).parents( ".col-md-6" ).addClass( "has-success" ).removeClass( "has-error" );
        }
      });
    });
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
  <script>
</script>
</body>
</html>
