<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
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
            <h3 class="box-title">Reportes | Detalle de Compra</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datoss" action="rpt_detalle_compras.php">
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
                  <select name="sucursal" id="sucursal" class="form-control select2">
                    <option value=""></option>
                    <option value="1">Díaz Ordaz</option>
                    <option value="2">Arboledas</option>
                    <option value="3">Villegas</option>
                    <option value="4">Allende</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="codigo_producto">*Código de producto:</label>
                  <input type="text" name="codigo_producto" id="codigo_producto" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="proveedor">*Proveedor:</label>
                  <select name="proveedor" id="proveedor" class="form-control select2">
                    <option value=""></option>
                    <?php
                      $cadena_proveedores = "SELECT PR.PROC_CVEPROVEEDOR, CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr";
                      $consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
                      oci_execute($consulta_proveedores);
                      while ($row_proveedores=oci_fetch_row($consulta_proveedores)) {
                    ?>
                      <option value="<?php echo $row_proveedores[0] ?>"><?php echo "$row_proveedores[1]"; ?></option>
                    <?php 
                      } 
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="departamento">*Departamento:</label>
                  <select name="departamento" id="departamento" class="form-control select2">
                    <option value=""></option>
                    <?php 
                      $cadena_departamento = "SELECT FAMC_FAMILIA, FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAMN_NIVEL = '1'";
                      $consulta_departamento = oci_parse($conexion_central, $cadena_departamento);
                      oci_execute($consulta_departamento);
                      while ($row_departamento=oci_fetch_row($consulta_departamento)) {
                      ?>
                        <option value="<?php echo $row_departamento[0] ?>"><?php echo "$row_departamento[1]"; ?></option>
                      <?php
                      }
                     ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="tipo_entrada">*Tipo de Entrada:</label>
                  <select name="tipo_entrada" id="tipo_entrada" class="form-control select2">
                    <option value=""></option>
                    <option value="ENTCOC">Con Orden de compra</option>
                    <option value="ENTSOC">Sin orden de compra</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="mostrar_datos">Mostrar datos</button>
            <input type="submit" value="Generar Excel" class="btn btn-danger">
          </div>
          </form>
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
    $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar_modulo.php"; // El script a dónde se realizará la petición.
          $.ajax({
                 type: "POST",
                 url: url,
                 data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
                 success: function(respuesta)
                 {
                  if (respuesta=="ok") {
                    alertify.success("Registro guardado correctamente");
                  }else if(respuesta=="duplicado"){
                    alertify.error("El registro ya existe");
                  }else {
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
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  })

</script>
</body>
</html>
