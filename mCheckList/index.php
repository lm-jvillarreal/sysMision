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
        <div class="box box-danger" <?php echo $solo_lectura?>>
          <!-- <div class="box box-danger"> -->
          <div class="box-header">
            <h3 class="box-title">Registro de Check_List</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <input type="hidden" name="id_registro" id="id_registro">
                    <label for="nombre_modulo">*Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del CheckList">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nombre_carpeta">*Sucursal</label>
                    <select name="sucursal" id="sucursal" class="form-control"></select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="descripcion_modulo">*Departamento</label>
                    <select name="departamento" id="departamento" class="form-control"></select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="id_categoria">*Categoría</label>
                    <select name="categoria" id="categoria" class="form-control select">
                      <option value=""></option>
                      <option value="1">Diario</option>
                      <option value="2">Semanal</option>
                      <option value="3">Quincenal</option>
                      <option value="4">Mensual</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="icono">*Calificar</label>
                    <select name="calificar" id="calificar" class="form-control select">
                      <option value=""></option>
                      <option value="1">Calificacion</option>
                      <option value="2">Check</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="icono">*Perfil</label>
                    <select name="perfil" id="perfil" class="form-control select">
                    </select>
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
            <h3 class="box-title">Lista de Check-List Existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_checklist" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th whidth="5%">#</th>
                        <th>Nombre</th>
                        <th>Sucursal</th>
                        <th>Departamento</th>
                        <th>Categoria</th>
                        <th>Calificar</th>
                        <th>Perfil</th>
                        <th whidth="5%">Editar</th>
                        <th whidth="5%">Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
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

<?php include '../footer.php'; include 'modal3.php';?>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    $('.select').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  })
  $(function(){
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
        url: "combo_sucursal.php",
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
  })
  $(function(){
    $('#perfil').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
        url: "combo_perfil.php",
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
  })
  $(function(){
    $('#departamento').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: "combo_departamentos.php",
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
  })
</script>
<script>
  function cargar_tabla() {
    $('#lista_checklist').dataTable().fnDestroy();
    $('#lista_checklist').DataTable( {
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
            title: 'Control Tiempo',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Control Tiempo',
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
        "dataSrc": ""
      },
      "columns": [
        { "data": "#" , "width": "5%"},
        { "data": "Nombre" },
        { "data": "Sucursal" },
        { "data": "Departamento" },
        { "data": "Categoria" },
        { "data": "Calificar" },
        { "data": "Perfil" },
        { "data": "Editar" , "width": "5%"},
        { "data": "Eliminar" , "width": "5%"},
      ]
    });
  }
  function cargar_tabla2() {
    $('#lista_sub_departamentos').dataTable().fnDestroy();
    $('#lista_sub_departamentos').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   true,
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
            title: 'Control Tiempo',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Control Tiempo',
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
        "url": "tabla_subd.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "#" , "width": "5%"},
        { "data": "Nombre" },
        { "data": "Editar" , "width": "5%"},
        { "data": "Eliminar" , "width": "5%"},
      ]
    });
  } 
  $(function (){
   cargar_tabla();
  })
  $.validator.setDefaults( {
    submitHandler: function () {
      $.ajax({
        type: "POST",
        url: 'guardar_registro.php',
        data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta=="ok") {
            alertify.success("Registro Guardado Correctamente");
            cargar_tabla();
            $('#form_datos')[0].reset();
            $("#sucursal").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $("#departamento").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $("#perfil").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $('#calificar').val('').trigger('change.select2');
            $('#categoria').val('').trigger('change.select2');
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
        nombre: "required",
        sucursal: "required",
        departamento: "required",
        categoria: "required",
        calificar: "required",
        perfil: "required"
      },
      messages: {
        nombre: "Campo requerido",
        sucursal: "Campo requerido",
        departamento: "Campo requerido",
        categoria: "Campo requerido",
        calificar: "Campo requerido",
        perfil: "Campo requerido"
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
  function editar(id){
    $.ajax({
      type: "POST",
      url: 'editar_registro.php',
      data:{'id':id}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        var array = eval(respuesta);

        $('#id_registro').val(id);
        $('#nombre').val(array[0]);
        $("#sucursal").select2("trigger", "select", {
          data: { id: array[1], text:array[2] }
        });
        $("#departamento").select2("trigger", "select", {
          data: { id: array[3], text:array[4] }
        });
        $('#categoria').val(array[5]).trigger('change.select2');
        $('#calificar').val(array[6]).trigger('change.select2');
        $("#perfil").select2("trigger", "select", {
          data: { id: array[7], text:array[8] }
        });
      }
    });
    // Evitar ejecutar el submit del formulario.
    return false;
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
          type: "POST",
          url: 'eliminar_registro.php',
          data:{'id':id}, // Adjuntar los campos del formulario enviado.
          success: function(respuesta)
          {
            cargar_tabla();
            alertify.success("Registro Eliminado Correctamente");
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
  }
  $('#modal-default3').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data().id;
    cargar_tabla2();
  });
  function eliminar_sd(id){
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
          url: 'eliminar_sd.php',
          data:{'id':id}, // Adjuntar los campos del formulario enviado.
          success: function(respuesta)
          {
            alertify.success("Registro Eliminado Correctamente");
            cargar_tabla2();
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
  }
  function editar_sd(id){
    $.ajax({
      type: "POST",
      url: 'editar_sd.php',
      data:{'id':id}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        var array = eval(respuesta);
        $('#id_sub_departamento_modal').val(id);
        $('#sub_departamento_modal').val(array[0]);
      }
    });
    // Evitar ejecutar el submit del formulario.
    return false;
  }
  $('#guardar_sub').click(function(){
    var sub_departamento    = $('#sub_departamento_modal').val();
    var id_sub_departamento = $('#id_sub_departamento_modal').val();
    $.ajax({
      type: "POST",
      url: 'guardar_sub.php',
      data: {'sub_departamento':sub_departamento,'id_sub_departamento':id_sub_departamento}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        if (respuesta=="ok") {
          alertify.success("Registro Guardado Correctamente");
          cargar_tabla2();
        }else if(respuesta=="duplicado"){
          alertify.error("El registro ya existe");
        }else {
          alertify.error("Ha ocurrido un error");
        }
      }
    });
    // Evitar ejecutar el submit del formulario.
    return false;
  })
</script>
</body>
</html>
