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
            <h3 class="box-title">Registro de Agrupaciones</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nombre_agrupacion">*Nombre Agrupacion</label>
                    <input type="text" name="nombre_agrupacion" id="nombre_agrupacion" class="form-control" placeholder="Nombre Agrupacion">
                  </div>
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
            <h3 class="box-title">Lista de Agrupaciones Existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_agrupaciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Nombre</th>
                        <th width="5%">Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
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
  function cargar_tabla_agrupaciones () {
    $('#lista_agrupaciones').dataTable().fnDestroy();
    $('#lista_agrupaciones').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
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
            title: 'Bitacora Servicios',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Bitacora Servicios',
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
        "url": "tabla_agrupaciones.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Eliminar" },
      ]
    });
   }  
  $(function (){
   cargar_tabla_agrupaciones();
  })
    $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar_agrupacion.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta)
          {
            if (respuesta=="ok") {
              alertify.success("Registro guardado correctamente");
              cargar_tabla_agrupaciones();
              $(":text").val(''); //Limpiar los campos tipo Text
            }else if(respuesta=="duplicado"){
              alertify.error("El registro ya existe");
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
          nombre_agrupacion: "required"
        },
        messages: {
          nombre_agrupacion: "Campo requerido"
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
  function mensaje(id){
    swal({
      title: "¿Está seguro de eliminar registro?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_departamento.php',
          data: '&id='+ id,
          type: "POST",
          success: function(respuesta) {
            if(respuesta == "ok"){
              cargar_tabla_departamentos();
              swal("El registro se ha eliminado.", {
                icon: "success",
              });
            }
          }
        });
      } else {
        swal("No se ha eliminado el registro.",{
          icon: "error",
        });
      }
    });
  }
</script>
<script>
  function act_nombre(numero){
    if ($('#input_nombre'+numero).hasClass('hidden')){
      $('#input_nombre'+numero).removeClass('hidden');  
    }
    else{
      $('#input_nombre'+numero).addClass('hidden');
    }
  }
  function act_nom(nombre,id){
    $.ajax({
      url: 'actualizar_agrupacion.php',
      data: '&id='+ id+'&nombre='+ nombre,
      type: "POST",
      success: function(respuesta) {
        if(respuesta == "ok"){
          alertify.success('Nombre Actualizada');
          cargar_tabla_agrupaciones();
        }
        else if (respuesta == "igual"){
          
        }
        else{
          alert(respuesta);
          alertify.error('Ha Ocurrido un Error');
        }
       }
    });
  }
  function eliminar(id){
    swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_agrupacion.php',
          data: '&id='+ id,
          type: "POST",
          success: function(respuesta) {
            if(respuesta == "ok"){
              alertify.success('Registro Eliminado');
              cargar_tabla_agrupaciones();
            }
            else{
              alertify.error('Ha Ocurrido un Error');
            }
          }
        });
      } else {
        swal("No se ha eliminado el registro.",{
          icon: "error",
        });
      }
    });
  }
</script>
</body>
</html>
