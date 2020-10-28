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
    <?php include 'menuV3.php'; ?>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="box box-danger" id="contenedor_tabla">
        <div class="box-header">
          <h3 class="box-title">Aplicar Exámen | Registro</h3>
        </div>
        <form action="" method="POST" id="form_datos">
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <label for="">*Exámen</label>
                  <select name="examen" id="examen" class="form-control" onchange="cargar_tabla()"></select>
                </div>
                <div class="col-md-6">
                  <label for="">*Persona</label>
                  <select name="persona" id="persona" class="form-control"></select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button  type='submit' class="btn btn-warning" id="terminar">Aplicar Exámen</button>
          </div>
        </form>
      </div>
      <div class="box box-danger" id="contenedor_tabla">
        <div class="box-header">
          <h3 class="box-title">Aplicar Exámen | Lista</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="lista_examenes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Examen</th>
                      <th>Empleado</th>
                      <th>Calificación</th>
                      <th>Ver</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Examen</th>
                      <th>Empleado</th>
                      <th>Calificación</th>
                      <th>Ver</th>
                      <th>Eliminar</th>
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
 <?php include '../footer2.php';?>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php include '../footer.php'; ?>
<script src="../plugins/bootstrap-fileinput-master/js/plugins/piexif.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/plugins/sortable.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/locales/fr.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/js/locales/es.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/themes/fa/theme.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-fileinput-master/themes/explorer-fa/theme.js" type="text/javascript"></script>
<!-- Page script -->
<script>
  function eliminar_aexamen(id) {
    swal({
      title: "¿Está seguro de eliminar categoria?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
      })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_aexamen.php',
          data: {'id':id},
          type: "POST",
          success: function(respuesta) {
            if (respuesta = "ok"){
              alertify.success("Registro Eliminado Correctamente");
              cargar_tabla();
            }else{
              alertify.error("Ha Ocurrido un Error");
            }
          }
        });
      } 
    });
  }
  $.validator.setDefaults( {
    submitHandler: function () {
      var url = "asignar_examen.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta == "ok") {
            alertify.success("Examen Asignado");
            cargar_tabla();
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
        examen: "required",
        persona: "required"

      },
      messages: {
        examen: "Campo requerido",
        persona: "Campo requerido"
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
  $('#examen').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
      url: "combo_examen.php",
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
  $('#persona').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: {
      url: "http://200.1.1.197/SMPruebas/mTiempoExtra/select_persona2.php",
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
  function cargar_tabla(){
    var id_examen = $('#examen').val();
    $('#lista_examenes').dataTable().fnDestroy();
    $('#lista_examenes').DataTable( {
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
            title: 'Efectivos',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Efectivos',
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
          "url": "tabla_examenes_aplicados.php",
          "dataSrc": "",
          "data":{'id_examen':id_examen},
      },
      "columns": [
        { "data": "#","width":"3%"},
        { "data": "Examen"},
        { "data": "Empleado"},
        { "data": "Calificacion","width":"5%"},
        { "data": "Ver","width":"3%"},
        { "data": "Eliminar","width":"3%"},
      ]
   });
  }
</script>
</body>
</html>
