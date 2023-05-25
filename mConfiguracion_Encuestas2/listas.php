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
          <h3 class="box-title">Asignacion de Encuestas a Trabajadores</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <form method="POST" id="form_datos">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">*Encuesta</label>
                    <select name="id_encuesta" id="id_encuesta" class="form-control" onchange="estilo_tablas2()"></select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">*Trabajadores</label>
                    <select name="id_trabajador" id="id_trabajador" class="form-control" onchange="cargar_datos(this.value)"></select>
                  </div>
                  <input type="hidden" name="sucursal" id="sucursal">
                  <input type="hidden" name="departamento" id="departamento">
                </div>
              </div>
            </div>
            <div>
              <div class="box-footer text-right">
                <button class="btn btn-warning" id="guardar"> Guardar Encuesta</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Trabajadores con Encuesta</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_invitados" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Nombre</th>
                        <th width="10%">Estado</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th width="5%">#</th>
                        <th>Nombre</th>
                        <th width="10%">Estado</th>
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
 <?php include 'modal2.php'?>
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
  $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar_invitado.php"; // El script a dónde se realizará la petición.
          $.ajax({
            type: "POST",
            url: url,
            data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
            success: function(respuesta)
            {
              if (respuesta=="ok") {
                alertify.success("Registro guardado correctamente");
                estilo_tablas2();
                $("#id_trabajador").select2("trigger", "select", {
                  data: { id: '', text:'' }
                });
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
          id_encuesta: "required",
          id_trabajador: "required"
        },
        messages: {
          id_encuesta: "Campo requerido",
          id_trabajador: "Campo requerido"
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
  })
  $('#id_trabajador').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
     url: "select_persona.php",
     type: "post",
     dataType: 'json',
     delay: 250,
     data: function (params){
      var id_encuesta = $('#id_encuesta').val();
      return {
        searchTerm: params.term, // search term
        id_encuesta: id_encuesta
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
        { "data": "Tipo" }
      ]
    });
  }
  function estilo_tablas2(){
    var id_encuesta = $('#id_encuesta').val();
    $('#lista_invitados').dataTable().fnDestroy();
    $('#lista_invitados thead th').each( function () {
      var title = $(this).text();
      $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%" />' );
    });
    var table = $('#lista_invitados').DataTable( {'language': {"url": "../plugins/DataTables/Spanish.json"},
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
        "url": "tabla3Original.php",
        "dataSrc": "",
        "data":{'id_encuesta':id_encuesta},
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Ver" }
      ]
    });
    table.columns().every( function () {
      var that = this;
      $( 'input', this.header() ).on( 'keyup change', function () {
        if ( that.search() !== this.value ) {
          that
          .search( this.value )
          .draw();
        }
      });
    });
  } 
    function plantilla(){
      location.href='plantilla.php';
    }
    $('#modal-default2').on('show.bs.modal', function(e) {
       var numero = $(e.relatedTarget).data().id;
       var folio = $('#encuesta'+numero).val();
       var id_trabajador = $('#trabajador'+numero).val();
       var url = "consulta_datos.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: {folio:folio}, // Adjuntar los campos del formulario enviado.
          success: function(respuesta)
          {
            $('#encuesta').html(respuesta);
            $('#id_encuesta_modal').val(folio);
            $('#id_encuesta_trabajador').val(id_trabajador);
            $('.combo2').select2({
              placeholder: 'Seleccione una opcion',
              lenguage: 'es'
            })
          }
        });
        $.ajax({
          type: "POST",
          url: "consulta_datos2.php",
          data: {'id_trabajador':id_trabajador,'folio':folio}, // Adjuntar los campos del formulario enviado.
          success: function(respuesta)
          {
            var array1 = eval(respuesta);

            $('#modal_encuesta_t').html(array1[0]);
            $('#modal_encuesta_e').html(array1[1]);
          }
        });
    });
    function guardar_resultado(){
      var url = "insertar_datos.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $('#form_encuesta').serialize(),
        success: function(respuesta) {
          if (respuesta=="ok") {
          alertify.success("Resultados Guardados Correctamente");
          $('#form_encuesta')[0].reset();
          $('#modal-default2').modal('hide');
          estilo_tablas2();
          }else if(respuesta == "1"){
            alertify.error("Verifica Campos");
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
      return false;
    }
    function cargar_datos(codigo){
      $.ajax({
        url: "datos_persona.php",
        type: "POST",
        dateType: "html",
        data: {'codigo':codigo},
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#sucursal').val(array[0]);
          $('#departamento').val(array[1]);
        }
      });
    }
    function eliminar_registro(id){
      swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "eliminar_invitado.php",
            type: "POST",
            dateType: "html",
            data: {'id':id},
            success: function(respuesta) {
              if(respuesta == "ok"){
                estilo_tablas2();
                alertify.success("Registro Eliminado");
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
