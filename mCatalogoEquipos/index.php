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
          <h3 class="box-title">Catálogo de Equipos | Registro</h3>
        </div>
        <div class="box-body">
          <form action="" method="POST" id="form_datos">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="equipo">*Equipo</label>
                <input type="text" name="equipo" id="equipo" class="form-control" placeholder="Nombre del equipo">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="marca">*Marca</label>
                <input type="text" name="marca" id="marca" class="form-control" placeholder="Marca del equipo">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="modelo">*Modelo</label>
                <input type="text" name="modelo" id="modelo" class="form-control" placeholder="Modelo del equipo">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="especificacion">*Especificación</label>
                <input type="text" name="especificacion" id="especificacion" class="form-control" placeholder="Especificaciones técnicas">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="no_serie">*No. Serie</label>
                <input type="text" name="no_serie" id="no_serie" class="form-control" placeholder="No. Serie">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="prioridad">*Prioridad</label>
                <select name="prioridad" id="prioridad" class="form-control has-error">
                  <option value=""></option>
                  <option value="3">Baja</option>
                  <option value="2">Media</option>
                  <option value="3">Alta</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="grupo">*Grupo</label>
                <select name="grupo" id="grupo" class="form-control">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="sucursal">*Sucursal</label>
                <select name="sucursal" id="sucursal" class="form-control">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="area">Depto./Área</label>
                <select name="area" id="area" class="form-control">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="tipo_equipo">*Tipo Equipo</label>
                <select name="tipo_equipo" id="tipo_equipo" class="form-control">
                  <option value=""></option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="proveedor">*Proveedor</label>
                <select name="proveedor" id="proveedor" class="form-control">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="fecha_alta">*Fecha de alta:</label>
                <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                  <input class="form-control" size="16" type="text" value="" readonly id="fecha_alta" name="fecha_alta">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <div class="box-footer text-right">
          <button class="btn btn-warning" id="btn_guardar">Guardar Datos</button>
        </div>
        </form>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php include '../footer2.php'; ?>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

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
  $('#proveedor').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
      url: "consulta_proveedores.php",
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
  });
  $('#grupo').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
      url: "consulta_grupo.php",
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
  });
  $('#tipo_equipo').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
      url: "consulta_tipo_equipo.php",
      type: "post",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          searchTerm: params.term, // search term
          grupo: $("#grupo").val()
        };
      },
      processResults: function (response) {
      return {
        results: response
      };
      },
      cache: true
    }
  });
  $('#sucursal').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    minimumResultsForSearch: Infinity,
    ajax: { 
      url: "consulta_sucursales.php",
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
  });
  $('#area').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
      url: "consulta_areas.php",
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
  });
  $('#prioridad').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    minimumResultsForSearch: Infinity
  })
  $.validator.setDefaults( {
    submitHandler: function () {
      var url = "insertar_equipo.php"; // El script a dónde se realizará la petición.
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
         }
       });
  // Evitar ejecutar el submit del formulario.
  cargar_tabla();
  return false;
  }
  });
  $(document).ready(function(){
    //cargar_tabla();
    $("#form_datos").validate( {
      errorElement: 'div',
      rules: {
        equipo: "required",
        marca: "required",
        modelo: "required",
        especificacion: "required",
        no_serie: "required",
        fecha_alta: "required",
        prioridad: {
            required: true,
        },
        grupo: {
            required: true,
        },
        sucursal: {
            required: true,
        },
        area: {
            required: true,
        },
        tipo_equipo: {
            required: true,
        },
        proveedor: {
            required: true,
        },
      },
      messages: {
        
      },
      errorElement: "em",
      errorPlacement: function ( error, element ) {
        // Add the `help-block` class to the error element
        $(element).closest('.form-group').find('.help-block').html(error.html());
      },
      highlight: function ( element, errorClass, validClass ) {
        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        $(element).closest('.form-group').find('.help-block').html('');
      }
    });
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
  </script>
</body>
</html>
