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
  <link rel="stylesheet" type="text/css" href="estilo_imagen.css">
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
      <div class="box box-danger" <?php echo $solo_lectura; ?>>
        <div class="box-header">
          <h3 class="box-title">Asignar Encuesta a Usuarios</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <form method="POST" id="form_datos" >
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>*Encuesta</label>
                    <select id="id_encuesta" name="id_encuesta" class="form-control" onchange="tabla_usuarios()"></select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>*Usuarios</label>
                    <select id="id_usuario" name="id_usuario[]" class="form-control" multiple></select>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <button class="btn btn-warning" id="guardar">Guardar</button>
            </div>
          </form>
        </div>
      </div>
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Lista de Usuarios</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista_usuarios" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th>Nombre</th>
                      <th width="15%">Estado de Encuesta</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th width="5%">#</th>
                      <th>Nombre</th>
                      <th width="15%">Estado de Encuesta</th>
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
 <?php include 'modal_respuestas.php'; ?>
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
  function tabla_usuarios(){
    var id_encuesta = $('#id_encuesta').val();
    $('#lista_usuarios').dataTable().fnDestroy();
    $('#lista_usuarios').DataTable( {'language': {"url": "../plugins/DataTables/Spanish.json"},
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
              title: 'Lista Invitados',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Lista Invitados',
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
        "url": "tabla_usuarios.php",
        "dataSrc": "",
        "data":{'id_encuesta':id_encuesta},
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Encuesta" }
      ]
    });
  }
  $.validator.setDefaults( {
      submitHandler: function () {
        $.ajax({
          type: "POST",
          url: 'guardar.php',
          dataType: "html",
          data: $('#form_datos').serialize(),
          success: function(respuesta)
          {
            if(respuesta == "ok"){
              alertify.success("Registro Guardado");
              $("#id_encuesta").select2("trigger", "select", {
                data: { id: '', text:'' }
              });
              document.getElementById("id_usuario").options.length = 0;
              llenar_notificaciones();
            }else{
              alertify.error("Ha Ocurrido un Error");
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
          id_encuesta: "required",
          id_usuario: "required"
        },
        messages: {
          id_encuesta: "Campo requerido",
          id_usuario: "Campo requerido"
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
  $(function () {
    $('#id_encuesta').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
        url: "combos_encuestas.php",
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
    $('#id_usuario').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
        url: "combos_usuarios.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          var id_encuesta = $('#id_encuesta').val();
          return {
            searchTerm: params.term, // search term
            id_encuesta : id_encuesta
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
  });
  $('#modal-default1').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      var encuesta = $('#encuesta_resp'+id).val();
      var usuario = $('#usuario_resp'+id).val();
      var url = "consulta_datos_encuesta2.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: 'datos_encuesta.php',
        data: {'id':encuesta}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          $('#n_encuesta').html(respuesta);
        }
      });
      $.ajax({
        type: "POST",
        url: url,
        data: {'encuesta':encuesta,'usuario':usuario}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          $('#encuesta').html(respuesta);
        }
      });
    });
</script>
</body>
</html>
