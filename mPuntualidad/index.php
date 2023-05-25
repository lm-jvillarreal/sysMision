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
        <form method="POST" id="form_datos">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Registro de Incidencias</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="id_persona">*Nombre</label>
                    <input type="hidden" name="id_registro" id="id_registro">
                    <select name="id_persona" id="id_persona" class="form-control select2" onchange="llenar()">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="departamento">*Departamento</label>
                    <input type="text" name="departamento" id="departamento" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-md-3">
	                <div class="form-group">
	              	  <label for="sucursal">*Sucursal</label>
	              	  <input type="text" name="sucursal" id="sucursal" class="form-control" readonly>
	                </div>
	              </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="categoria">*Categoría</label>
                    <select name="categoria" id="categoria" class="form-control select2" style="width: 230px ">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="incidencia">*Incidencia</label>
                      <select name="incidencia" id="incidencia" class="form-control select2" onchange="ocultar(this.value)">
                      </select>
                    </div>
                  </div>
                  <div>
                    <div id="contenedor" style="display:none;">
                      <div class="col-md-3">
                      <!-- style="display: none" -->
                        <div class="form-group">
                          <label for="fecha_inicio">*Fecha de inicio:</label>
                          <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd"      data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd" >
                            <input  class="form-control" size="16" type="text" value="" readonly id="fecha_inicio" name="fecha_inicio" >
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" ></span></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3" >
                <!-- style="display: none" -->
                        <div class="form-group">
                          <label for="fecha_final">*Fecha final:</label>
                          <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_final" data-link-format="yyyy-mm-dd">
                            <input class="form-control" size="16" type="text" value="" readonly id="fecha_final" name="fecha_final">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
		              <div class="col-md-3">
                    <div class="form-group">
                      <label for="comentario">*Comentario</label>
                      <input type="text" name="comentario" id="comentario" class="form-control" placeholder="Agregue un comentario...">
                    </div>
                  </div>
                </div>
                <div class="box-footer text-right">
                  <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
                </div>
              </div>
            </div>
          </form>
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
                        <th width ="5%"> ID</th>
                        <th width="35%">No. Empleado</th>
                        <th width="35%">Departamento</th>
                        <th width="35%">Sucursal</th>
                        <th width="15%">Incidencia</th>
                        <th width="15%">Categoría</th> 
                        <!-- <th width="15%">Decision</th> -->
                        <th width= "5%">Comentario</th>
                        <th width= "5%">Fecha</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th width ="5%">ID</th>
                        <th width="35%">No. Empleado</th>
                        <th width="35%">Departamento</th>
                        <th width="35%">Sucursal</th>
                        <th width="15%">Incidencia</th>
                        <th width="15%">Categoría</th> 
                        <!-- <th width="15%">Decision</th> -->
                        <th width ="5%">Comentario</th>
                        <th width= "5%">Fecha</th>
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
              "url": "http://200.1.1.197/SMPruebas/mRegistro_incidencias/tabla_registros_asistencia.php",
              "dataSrc": "",
              
          },
          "columns": [
              { "data": "id" },
              { "data": "nombre" },
              { "data": "departamento" },
              { "data": "sucursal" },
              { "data": "incidencia" },
              { "data": "categoria" },
	            // { "data": "comentario" },
              { "data": "activo"},
              { "data": "fecha"}
          ]
      });
    }
      $(function (){
   cargar_tabla();
  })
  $(function () {
    $('#id_persona').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: " http://200.1.1.197/SMPruebas/mRegistro_incidencias/select_persona.php",
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
    $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar_registro.php"; // El script a dónde se realizará la petición.
          $.ajax({
                 type: "POST",
                 url: url,
                 data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
                 success: function(respuesta)
                 {
                  if (respuesta=="ok_nuevo") {
                    alertify.success("Registro guardado correctamente");
                  }else if(respuesta=="actualizado"){
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
          id_persona:   "required",
          departamento: "required",
          incidencia:   "required",
	        comentario:   "required",
          sucursal:     "required",
          categoria:    "required",
        },
        messages: {
          id_persona:   "Campo requerido",
          departamento: "Campo requerido",
          incidencia:   "Campo requerido",
	        comentario:   "Campo Requerido",
          sucursal:     "Campo Requerido",
          categoria:    "Campo Requerido",
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
    $('#incidencia').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: "../mRegistroIncidencias/select_incidencia.php",
     type: "post",
     dataType: 'json',
     delay: 250,
     data: function (params) {
       var categoria= $('#categoria').val();
      return {
        searchTerm: params.term,
        categoria:categoria // search term
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
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: "../mRegistroIncidencias/select_categoria.php",
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
      placeholder: 'Seleccione una opcion',
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
    var url = 'http://200.1.1.197/SMPruebas/mRegistro_incidencias/consulta_datos_editar.php';
    $.ajax({
      url: url,
      type: "POST",
      dateType: "html",
      data: {id: id},
      success: function(respuesta) {
        var array = eval(respuesta);
        $("#id_registro").val(array[0]);
        $("#id_persona").select2("trigger", "select", {
          data: { id: array[1], text: array[2] }
        });
        $("#categoria").select2("trigger", "select", {
          data: { id: array[3], text: array[4] }
        });
        $("#incidencia").select2("trigger", "select", {
          data: { id: array[5], text: array[6] }
        });
        $("#comentario").val(array[7]);
        $("#accion").select2("trigger", "select", {
          data: { id: array[8], text: array[9] }
        });
        $("#fecha_inicio").val(array[11]);
        $("#fecha_final").val(array[12]); 
      },
    });
  }
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
          alertify.success("Incidencia Autorizada");
        }
      },
      error: function(xhr, status) {
          alert("error");
          //alert(xhr);
      },
    });
  }
  function llenar(){
    var id_persona = $('#id_persona').val();
    var id_registro =$('#id_registro').val();
    
    if (id_persona != ""){
      var url = 'http://200.1.1.197/SMPruebas/mRegistro_incidencias/llenar.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {'id_persona': id_persona},
        success: function(respuesta) {
          //evaluar el array y separarlo para imprimir por campos
          var array = eval(respuesta)
          $('#departamento').val(array[1]);
          $('#sucursal').val(array[0]);
        },
        error: function(xhr, status) {
            alert("error");
            alert(xhr);
        },
      });
    }
  }
  function ocultar(valor){
    if (valor==3){
      $('#contenedor').show();
    }else{
      $('#contenedor').hide();
    }
  }
  $('.form_datetime').datetimepicker({
          //language:  'fr',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          forceParse: 0,
          showMeridian: 1
      });
      $('.form_date').datetimepicker({
          language:  'es',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          minView: 2,
          forceParse: 0
      });
      $('.form_time').datetimepicker({
          language:  'fr',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 1,
          minView: 0,
          maxView: 1,
          forceParse: 0
      });
</script>
</body>
</html>