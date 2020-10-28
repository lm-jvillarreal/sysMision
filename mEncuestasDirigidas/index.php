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
          <form method="POST" id="form_datos" >
            <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                	<input type="text" name="id_registro" id="id_registro" class="hidden">
                  <label for="n_encuesta">*Nombre Encuesta</label>
                  <input id="n_encuesta" name="n_encuesta" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <label for="">Comentario Final</label>
                <br>
                <input type="checkbox" name="comentario" id="comentario">
              </div>
            </div>
            <div class="box-footer text-right">
              <button class="btn btn-warning" id="guardar">Guardar Encuesta</button>
            </div>
          </form>
          <div class="row" style="display: none" id="form_preguntas">
            <div class="col-md-12">
              <input type="hidden" name="folio_encuesta" id="folio_encuesta" class="form-control" value="0">
              <label for="">*Pregunta</label>
              <input type="text" name="pregunta" id="pregunta" onkeyup="if(event.keyCode == 13)insertar_pregunta(this.value)" class="form-control">
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
                      <th width="10%">Eliminar</th>
                    </tr>
                  </thead>
                  <tfoot>
	                  <tr>
               	      <th width="5%">#</th>
                      <th>Nombre</th>
                      <th width="10%">Eliminar</th>
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
                      <th width="10%">Editar</th>
                      <th width="10%">Eliminar</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th width="5%">#</th>
                      <th>Nombre</th>
                      <th width="10%">Editar</th>
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
    // include 'modal.php';
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
  function estilo_tablas() {
    var folio_encuesta = $('#folio_encuesta').val();
   	$('#lista_preguntas').dataTable().fnDestroy();
    $('#lista_preguntas').DataTable( {'language': {"url": "../plugins/DataTables/Spanish.json"},
      "paging":   false,
      "dom": 'Bfrtip',
      "buttons": [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ],
      "ajax": {
        "type": "POST",
        "url": "tabla.php",
        "dataSrc": "",
        "data":{'folio_encuesta':folio_encuesta},
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Eliminar" }
      ]
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
              title: 'Lista Encuestas',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Lista Encuestas',
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
        { "data": "Editar" },
        {"data":  "Eliminar"}
      ]
    });
  }
  function ver(numero){
    if($('#pregunta'+numero).hasClass('hidden')){
      $('#pregunta'+numero).removeClass('hidden');
    }else{
      $('#pregunta'+numero).addClass('hidden');
    }
  }   
  function actualizar_pregunta(id,pregunta){
    $.ajax({
      type: "POST",
      url: 'actualizar_pregunta.php',
      dataType: "html",
      data: {'id':id,'pregunta':pregunta},
      success: function(respuesta)
      {
        if(respuesta == "ok"){
          alertify.success("Pregunta Actualizada Correctamente");
          estilo_tablas();
        }else{
          alertify.error("Ha Ocurrido un Error");
        }
      }
    });
  }
  function eliminar_pregunta(id){
    swal({
      title: "¿Está seguro de eliminar registro?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "POST",
          url: 'eliminar_pregunta.php',
          dataType: "html",
          data: {'id':id},
          success: function(respuesta)
          {
            if(respuesta == "ok"){
              alertify.success("Pregunta Eliminada Correctamente");
              estilo_tablas();
            }else{
              alertify.error("Ha Ocurrido un Error");
            }
          }
        });
      }
    });
  }
  function eliminar_encuesta(id){
    swal({
      title: "¿Está seguro de eliminar registro?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "POST",
          url: 'eliminar_encuesta.php',
          dataType: "html",
          data: {'id':id},
          success: function(respuesta)
          {
            if(respuesta == "ok"){
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
  $(function (){
    estilo_tablas2();
  })
    $.validator.setDefaults( {
      submitHandler: function () {
       	$.ajax({
          type: "POST",
          url: 'insertar_encuesta.php',
          dataType: "html",
          data: $('#form_datos').serialize(),
          success: function(respuesta)
          {
            var array = eval(respuesta);
            var mensaje = array[0];
            var folio = array[1];

            if(mensaje == "ok"){
              alertify.success("Encuesta Guardada Correctamente");
              $('#form_datos')[0].reset();
              $('#folio_encuesta').val(folio);
              estilo_tablas();
              estilo_tablas2();
              $('#form_preguntas').show();
              $('#form_datos').hide();
            }else if (mensaje == "duplicado"){
              alertify.error("Encuesta Duplicada");
            }else if (mensaje == "vacio"){
              alertify.error("Verifica Campos");
              $('#n_encuesta').focus();
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
          n_encuesta: "required"
        },
        messages: {
          n_encuesta: "Campo requerido"
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
    function insertar_pregunta(pregunta){
      var folio_encuesta = $('#folio_encuesta').val();
      $.ajax({
        type: "POST",
        url: 'insertar_pregunta.php',
        data: {'pregunta':pregunta,'folio_encuesta':folio_encuesta}, // Adjuntar los campos del formulario enviado.
        success: function(response)
        {
          if(response == "ok"){
            alertify.success("Pregunra Guardada Correctamente");
            $('#pregunta').val("");
            estilo_tablas();
          }else if (response == "duplicado"){
            alertify.error("Respuesta Duplicada");
            $('#pregunta').val("");
          }else if (response == "vacio"){
            alertify.error("Verifica Campos");
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
    }
    function editar_registro(id){
      $.ajax({
        type: "POST",
        url: 'consulta_encuesta.php',
        data: {'id':id}, // Adjuntar los campos del formulario enviado.
        success: function(response)
        {
          var array = eval(response);
          $('#n_encuesta').val(array[0]);
          if(array[1] == "1"){
            $('#comentario').attr('checked',true);
          }else{
            $('#comentario').attr('checked',false);
          }
          $('#folio_encuesta').val(id);
          $('#id_registro').val(id);
          estilo_tablas();
        }
      });
    }
  </script>
</body>
</html>
