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
            <h3 class="box-title">Creación de Encuestas</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                  	<input type="text" name="id_registro" id="id_registro" class="hidden">
                    <label for="n_encuesta">*Nombre Encuesta</label>
                    <input id="n_encuesta" name="n_encuesta" class="form-control">
                  </div>
                </div>
                <!-- <form method="POST" id="form_datos" enctype="multipart/form-data"> -->
                <div class="col-md-6">
                  <label for="">*Importar Preguntas</label>
                  <input type="file" name="plantilla" id="plantilla">
                </div>
                <!-- </form> -->
              </div>
              <div class="box-footer text-right">
                <a class="btn btn-danger" id="d_plantilla" onclick="plantilla();"><i class="fa fa-cloud-download"></i> Descargar Plantilla</a>
                <!-- <button class="btn btn-danger" id="importar" onclick="cargar_excel();"><i class="fa fa-cloud-upload"></i> Importar</button> -->
                <button class="btn btn-warning" id="guardar"><i class="fa fa-floppy-o"></i> Guardar Encuesta</button>
              </div>
            </form>
            <div class="col-md-4">
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Tipos de Pregunta!</h4>
                <h5>Cualitativo &nbsp; &nbsp;= 1 (Si/No)</h5>
                <h5>Cuantitativo = 2 (1 al 5)</h5>
                <h5>Libre &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;= 3 (Texto Libre)</h5>
                <h5>Nueva &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;= 4 (Opcion Multiple)</h5>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Preguntas Cargadas</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_preguntas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Respuestas</th>
                      </tr>
                    </thead>
                    <tfoot>
  	                  <tr>
                   	      <th width="5%">#</th>
                          <th>Nombre</th>
                          <th>Tipo</th>
                          <th>Respuestas</th>
  	                  </tr>
                  	</tfoot>  
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Encuestas Existentes</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_encuestas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Nombre</th>
                        <th width="10%">Ver</th>
                        <th width="10%">Eliminar</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th width="5%">#</th>
                        <th>Nombre</th>
                        <th width="10%">Ver</th>
                        <th width="10%">Eliminar</th>
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
 <?php 
    include '../footer2.php';
    include 'modal.php';
    include 'modal3.php';
 ?>
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
  function estilo_tablas3(id_pregunta) {
    $('#lista_respuestas').dataTable().fnDestroy();
    $('#lista_respuestas').DataTable( {'language': {"url": "../plugins/DataTables/Spanish.json"},
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
        "url": "tabla4.php",
        "dataSrc": "",
        "data":{'id_pregunta':id_pregunta},
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Eliminar" }
      ]
    });
  }
  function estilo_tablas() {
   	$('#lista_preguntas').dataTable().fnDestroy();
    $('#lista_preguntas').DataTable( {'language': {"url": "../plugins/DataTables/Spanish.json"},
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
        "url": "tabla.php",
        "dataSrc": "",
        "data":""
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Tipo" },
        { "data": "Respuestas" }
      ]
    });
  }
  function eliminar_respuesta(id,id_pregunta){
    swal({
      title: "¿Está seguro de eliminar registro?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
      })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_respuesta.php',
          data: '&id='+ id,
          type: "POST",
          success: function(respuesta) {
            if (respuesta = "ok"){
              alertify.success("Registro Eliminado Correctamente");
              estilo_tablas3(id_pregunta);
            }else{
              alertify.error("Ha Ocurrido un Error");
            }
          }
        });
      } 
    });
  } 
  function estilo_tablas2() {
    $('#lista_encuestas').dataTable().fnDestroy();
    $('#lista_encuestas').DataTable( {'language': {"url": "../plugins/DataTables/Spanish.json"},
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
        "url": "tabla2.php",
        "dataSrc": "",
        "data":""
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Ver" },
        { "data": "Eliminar" }
      ]
    });
  }   
  $(function (){
    estilo_tablas2();
  })
    $.validator.setDefaults( {
      submitHandler: function () {
        var f = $(this);
        var formData = new FormData(document.getElementById("form_datos"));
        formData.append("dato", "valor");
        //formData.append(f.attr("name"), $(this)[0].files[0]);
       	$.ajax({
          type: "POST",
          url: 'importar.php',
          dataType: "html",
          data: formData,
          cache: false,
          contentType: false,
  	     	processData: false
  		  })
        .done(function(res){
          if(res == "ok"){
            alertify.success("Encuesta Creada Correctamente");
            $('#form_datos')[0].reset();
            estilo_tablas();
            estilo_tablas2();
          }else{
            alertify.error("Ocurrio un Error");
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $( document ).ready( function () {
      $( "#form_datos" ).validate( {
        rules: {
          n_encuesta: "required",
          plantilla: "required"
        },
        messages: {
          n_encuesta: "Campo requerido",
          plantilla: "Campo requerido"
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
    function plantilla(){
      location.href='plantilla.php';
    }
    $('#modal-default').on('show.bs.modal', function(e) {
      var folio = $(e.relatedTarget).data().id;
      var url = "consulta_datos.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {folio:folio}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          $('#encuesta').html(respuesta);
          $('.combo2').select2({
            placeholder: 'Seleccione una opcion',
            lenguage: 'es'
          })
        }
      });
    });
    $('#modal-default3').on('show.bs.modal', function(e) {
      var id_pregunta = $(e.relatedTarget).data().id;
      $.ajax({
        type: "POST",
        url: 'consulta_pregunta.php',
        data: {id_pregunta:id_pregunta}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          $('#n_pregunta').html(respuesta);
        }
      });
      estilo_tablas3(id_pregunta);
      $('#id_pregunta_modal').val(id_pregunta);
    });
    function guardar_respuesta(respuesta){
      var id_pregunta = $('#id_pregunta_modal').val();
      $.ajax({
        type: "POST",
        url: 'guardar_respuesta.php',
        data: {'respuesta':respuesta,'id_pregunta':id_pregunta}, // Adjuntar los campos del formulario enviado.
        success: function(response)
        {
          if(response == "ok"){
            alertify.success("Respuesta Guardada Correctamente");
            estilo_tablas3(id_pregunta);
            $('#respuesta').val("");
          }else if (response == "duplicado"){
            alertify.error("Respuesta Duplicada");
            $('#respuesta').val("");
          }else if (response == "vacio"){
            alertify.error("Verifica Campos");
            $('#respuesta').focus();
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
      return false;
    }
    function eliminar_encuesta(id){
      swal({
        title: "¿Está seguro de eliminar encuesta?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: 'eliminar_encuesta.php',
            data: '&id='+ id,
            type: "POST",
            success: function(respuesta) {
              if (respuesta = "ok"){
                alertify.success("Encuesta Eliminada Correctamente");
                estilo_tablas2();
              }else{
                alertify.error("Ha Ocurrido un Error");
              }
            }
          });
        } 
      });
    }
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);
  </script>
</body>
</html>
