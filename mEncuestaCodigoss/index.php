<?php
  include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion_oracle.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include '../head.php'; ?>
    <link href="../plugins/bootstrap-fileinput-master/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../plugins/VenoBox-master/venobox/venobox.css" type="text/css" media="screen" />
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
      <div class="box box-danger" id="contenedor_categoria" <?php echo $solo_lectura; ?>>
        <form method="POST" id="form_datos">
          <div class="box-header">
            <h3 class="box-title">Catálogo de Códigos | Creación de Exámen</h3>
          </div>
          <div class="box-body">
            <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                  <label for="nombre">*Nombre:</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de Exámen">
                  <input type="text" name="id_registro" id="id_registro" value="0" class="hidden">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="departamento">*Departamento:</label>
                  <select name="departamento" id="departamento" class="form-control"onchange="habilitar();">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button type="button" class="btn btn-warning" id="editar" disabled>Seleccionar Códigos</button>
            <button type="submit" class="btn btn-danger" id="guardar">Guardar</button>
          </div>
        </form>
      </div>
      <div class="box box-danger" id="contenedor_tabla">
        <div class="box-header">
          <h3 class="box-title">Catálogo de Códigos | Lista de Exámenes</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <form action="" method="POST" id="form_detalle">
                <table id="lista_examenes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Departamento</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Departamento</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </tfoot>
                </table>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="box box-danger" id="contenedor_tabla2" style="display: none;">
        <div class="box-header">
          <h3 class="box-title">Catálogo de Códigos | Lista de Códigos</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <form action="" method="POST" id="form_detalle">
                <table id="lista_codigos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Código</th>
                      <th>Descripción</th>
                      <th>Seleccionar</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Código</th>
                      <th>Descripción</th>
                      <th>Seleccionar</th>
                    </tr>
                  </tfoot>
                </table>
                </form>
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
<!-- Page script -->
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script>
        $(function () {
          $('#departamento').select2({
            placeholder: 'Seleccione una opción',
            lenguage: 'es',
            ajax: { 
              url: "consulta_departamentos.php",
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
  function habilitar(){
    $('#editar').removeAttr('disabled');
    cargar_tabla();
    seleccionar_todo();
  }
  $.validator.setDefaults( {
    submitHandler: function () {
      var url = "guardar_examen.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if(respuesta == "ok"){
            alertify.success("Registro Guardado Correctamente");
            $('#form_datos')[0].reset();
            $("#catalogo").select2("trigger", "select", {
              data: {id: '',text: ''}
            });
            $('#tipo').val('').trigger('change.select2');
            $('#contenedor_tabla2').hide();
            $('#editar').attr('disabled',true);
            cargar_tabla2();
            cargar_tabla();
          }else if (respuesta = "vacio"){
            alertify.error("Verifica Campos");
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
        nombre: "required",
        tipo: "required",
        catalogo: "required"
      },
      messages: {
        nombre: "Campo requerido",
        tipo: "Campo requerido",
        catalogo: "Campo requerido"
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
  function limpiar_filtro(){
    var table = $('#lista_codigos').DataTable();
    table
     .search( '' )
     .columns().search( '' )
     .draw();
  }
  $('#tipo').select2({
    placeholder: 'Seleccione un tipo de Exámen',
    lenguage: 'es'
  });
  $('#catalogo').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
      url: "combos_catalogos.php",
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
  function seleccionar_todo(){
    var cantidad = document.getElementsByClassName("botones").length;
    for (var i = 1; i <= cantidad; i++) {
      seleccionar(i);
    }
  }
  function cargar_tabla(){
    var departamento = $('#departamento').val();
    var id_examen   = $('#id_registro').val();
    
    $('#lista_codigos thead th').each( function () {
      var title = $(this).text();
      $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%" />' );
    });

    $('#lista_codigos').dataTable().fnDestroy();
    var table = $('#lista_codigos').DataTable( {
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
          },{
              text: 'Seleccionar Todos',
              action: function (  ) {
                seleccionar_todo();
              },
              className: 'btn btn-danger',
              counter: 1
          }
        ],
      "ajax": {
          "type": "POST",
          "url": "tabla_codigos.php",
          "dataSrc": "",
          "data":{'departamento':departamento},
      },
      "columns": [
        { "data": "#","width":"3%"},
        { "data": "Codigo","width":"5%"},
        { "data": "Descripcion"},
        { "data": "Seleccionar","width":"3%"},
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
  function cargar_tabla2(){
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
          "url": "tabla_examenes.php",
          "dataSrc": "",
      },
      "columns": [
        { "data": "#","width":"3%"},
        { "data": "Nombre"},
        { "data": "Departamento","width":"10%"},
        { "data": "Editar","width":"5%"},
        { "data": "Eliminar","width":"3%"},
      ]
   });
  }
  cargar_tabla2();
  function seleccionar(numero){
    if($('#boton_'+ numero).hasClass('btn-default')){
      $('#boton_'+ numero).removeClass('btn-default');
      $('#boton_'+ numero).addClass('btn-success');
      $('#selecciona_'+ numero).val('1');
    }else{
      $('#boton_'+ numero).removeClass('btn-success');
      $('#boton_'+ numero).addClass('btn-default');
      $('#selecciona_'+ numero).val('0');
    }
  }
  $('#editar').click(function(){
    $('#contenedor_tabla2').show();
    cargar_tabla();
    seleccionar_todo();
  })
  function editar_examen(id){
    $.ajax({
      type: "POST",
      url: 'editar_examen.php',
      data: {'id':id}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        var array = eval(respuesta);
        $('#nombre').val(array[0]);
        $('#id_registro').val(id);
        $("#departamento").select2("trigger", "select", {
          data: {id: array[2],text: array[3]}
        });
        $('#tipo').val(array[3]).trigger('change.select2');
        $('#contenedor_tabla2').show();
      }
    });
  }
  function eliminar_codigo(codigo) {
    swal({
      title: "¿Está Seguro de Eliminar Codigo del Exámen?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
      })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_dcodigo.php',
          data: {'codigo':codigo},
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
  function eliminar_examen(id) {
    swal({
      title: "¿Está Seguro de Eliminar Exámen?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
      })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_examen.php',
          data: {'id':id},
          type: "POST",
          success: function(respuesta) {
            if (respuesta = "ok"){
              alertify.success("Registro Eliminado Correctamente");
              cargar_tabla2();
            }else{
              alertify.error("Ha Ocurrido un Error");
            }
          }
        });
      } 
    });
  }
</script>
</body>
</html>
