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
            <h3 class="box-title">Registro de Permisos</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="nombre">*Permiso: </label>
                  <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresa un nombre">
                </div>
              </div>
             </div>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
          </div>
          
        </form>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Permisos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_modulos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Permiso</th>
                        <!-- <th width="15%">Fecha</th>-->
                        <th width="15%">Activo</th> 
                        
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Permiso</th>
                        <!-- <th>Fecha</th>  -->                    
                      
                        <th>Activo</th>
                      </tr>
                    </tfoot>
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

<!-- ./wrapper -->

<?php include '../footer.php'; ?>
<!-- Page script -->
<script>
  $(document).ready(function() {
    cargar_tabla();
  })
  $.validator.setDefaults( {
    submitHandler: function () {
      var url = "insertar_permiso.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta=="ok") {
            alertify.success("Registro guardado correctamente");
            cargar_tabla();
          }else if(respuesta=="duplicado"){
            alertify.error("El registro ya existe");
          }else {
            alertify.error("Ha ocurrido un error");
          }
          $(":text").val(''); //Limpiar los campos tipo Text
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
        
      },
      messages: {
        nombre: "Campo requerido",
        
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
        $( element ).parents( ".col-md-4" ).addClass( "has-error" ).removeClass( "has-success" );
      },
      unhighlight: function (element, errorClass, validClass) {
        $( element ).parents( ".col-md-4" ).addClass( "has-success" ).removeClass( "has-error" );
      }
    });
  });
  function estatus(registro){
    var id_registro = registro;
    var url = 'cambiar_estatus.php';
    $.ajax({
     url: url,
      type: "POST",
      dateType: "html",
      data: {id_registro: id_registro},
      success: function(respuesta) {
        if (respuesta=="ok") {
         alertify.success("Permiso modificado correctamente");
        }
      },
      error: function(xhr, status) {
         alert("error");
          alert(xhr);
      },
    });
  }
 
  function cargar_tabla(){
    $('#lista_modulos').dataTable().fnDestroy();
    $('#lista_modulos').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "ajax": {
            "type": "POST",
            "url": "lista_permisos.php",
            "dataSrc": "",
            "data":""
        },
        "columns": [
            { "data": "id" },
            { "data": "nombre" }, 
            { "data": "activo" },
          
        ]
    });
  }
  </script>
</body>
</html>
