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
            <h3 class="box-title">Catálogo de Incidencias</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="nombre">*Incidencia: </label>
                  <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de la incidencia">
                  <input type="hidden" name="id_registro" id="id_registro">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="categoria">*Categoría:</label>
                  <select name="categoria" id="categoria" class="form-control select">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="gravedad">*Gravedad:</label>
                  <select name="gravedad" id="gravedad" class="form-control select">
                    <option value=""></option>
                    <option value="Alta">Alta</option>
                    <option value="Media">Media</option>
                    <option value="Baja">Baja</option>
                  </select>
                </div>
              </div>
                <div class="col-md-3">
                <div class="form-group">
                  <label for="accion">*Acción Sugerida:</label>
                  <select name="accion" id="accion" class="form-control select2">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="formato">*Formato:</label>
                  <select name="formato" id="formato" class="form-control select2">
                    <option value=""></option>
                  </select>
                </div>
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
            <h3 class="box-title">Lista de Incidencias</h3>
          </div>
          <div class="box-body">
            <div class="row">
             <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_incidencias" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Incidencia</th>
                        <th width="15%">Categoría</th>
                        <th width="15%">Gravedad</th>
                        <th width="15%">Acción Sugerida</th>
                        <th width="5%">Activo</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                         <th width="5%">ID</th>
                        <th width="15%">Incidencia</th>
                        <th width="15%">Categoría</th>
                        <th width="15%">Gravedad</th>
                        <th width="15%">Acción Sugerida</th>
                        <th width="5%">Activo</th>
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

  function cargar_tabla(){
      $('#lista_incidencias').dataTable().fnDestroy();
      $('#lista_incidencias').DataTable( {
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
              "url": "tabla_incidencias.php",
              "dataSrc": ""
          },
          "columns": [
              { "data": "id_incidencia" },
              { "data": "nombre" },
              { "data": "categoria" },
              { "data": "gravedad" },
              { "data": "accion" },
              { "data": "activo"}
          ]
      });
    }
      $(function (){
   cargar_tabla();
  })
    $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar_incidencia.php"; // El script a dónde se realizará la petición.
          $.ajax({
                 type: "POST",
                 url: url,
                 data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
                 success: function(respuesta)
                 {
                  if (respuesta=="ok_nuevo") {
                    alertify.success("Registro guardado correctamente");
                  }else if(respuesta=="ok_actualizado"){
                    alertify.success("Registro actualizado correctamente");
                  }else if(respuesta=="duplicado"){
                    alertify.error("El registro ya existe");
                  }else {
                    alertify.error("Ha ocurrido un error");
                  }
                  $(":text").val(''); //Limpiar los campos tipo Text
                  cargar_tabla();
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
          gravedad: "required",
          categoria: "required",
          accion: "required",
          formato: "required",
        },
        messages: {
          nombre: "Campo requerido",
          gravedad: "Campo requerido",
          categoria: "Campo requerido",
          accion: "Campo requerido",
          formato: "Campo requerido",
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
  </script>
  <script>
  $(function () {
    $('.select').select2({
      placeholder: 'Seleccione una opción',
      lenguage: 'es'
    })
  })
  $(function () {
    $('#formato').select2({
      placeholder: 'Seleccione una opción',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: "select_formato.php",
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
  $(function () {
    $('#categoria').select2({
      placeholder: 'Seleccione una opción',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: "select_categoria.php",
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
  $(function () {
    $('#accion').select2({
      placeholder: 'Seleccione una opción',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: "select_accion.php",
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
   function editar(id){
    var url = 'consulta_datos_editar.php';
    $.ajax({
      url: url,
      type: "POST",
      dateType: "html",
      data: {id: id},
      success: function(respuesta) {
        var array = eval(respuesta);
        $("#id_registro").val(array[0]);
        $("#nombre").val(array[1]);
        
        $("#gravedad").select2("trigger", "select", {
          data: { id: array[4], text: array[4] }
        });
        $("#categoria").select2("trigger", "select", {
          data: { id: array[2], text: array[3] }
        });
        $("#formato").select2("trigger", "select", {
          data: { id: array[2], text: array[3] }
        });
        $("#accion").select2("trigger", "select", {
          data: { id: array[5], text: array[6] }
        });
      },
    });
  }
  // #gravedad").val.(array[3]).trigger('change.select2');
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
          //alert(xhr);
      },
    });
  }
</script>
</body>
</html>