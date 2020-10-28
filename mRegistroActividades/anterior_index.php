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
          <h3 class="box-title">Bitacora de Actividades</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
            </a>
          </div>
        </div>
        <div class="box-body">
          <form id="form-datos" method="POST">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <input type="hidden" id="id_actividad" name="id_actividad" value="0">
                  <label for="id_persona">*Selecciona Usuario</label>
                  <select name="id_persona" id="id_persona" class="form-control" >
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="actividad">*Actividad</label>
                  <input type="text" name="actividad" id="actividad" class="form-control" placeholder="Nombre de la Actividad">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha">*Fecha:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="fecha" data-link-format="yyyy-mm-dd" value="">
                    <input class="form-control" size="16" type="text"  id="fecha" name="fecha">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
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
          <h3 class="box-title">Filtro de Actividades por Usuario</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
            </a>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="id_usuario">*Selecciona Usuario</label>
                <select name="id_persona2" id="id_persona2" class="form-control" >
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="fecha">*Fecha:</label>
                <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha" data-link-format="yyyy-mm-dd" value="">
                  <input class="form-control" size="16" type="text"  id="fecha3" name="fecha3">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="fecha">*Fecha:</label>
                <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha" data-link-format="yyyy-mm-dd" value="">
                  <input class="form-control" size="16" type="text"  id="fecha4" name="fecha4">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <a  class="btn btn-danger" onclick="generar_pdf()"><i class="fa fa-file-pdf-o"></i> Generar PDF</a>
          </div>
        </div>
      </div>
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Lista de Actividades</h3>
          <div class="box-tools pull-right">
            <a onclick="estilo_tablas();">
              <i class="fa fa-refresh fa-spin"></i>
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </a>
          </div>
          <br>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista_actividades" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th width="25%">Nombre</th>
                      <th>Actividad</th>
                      <th width="10%">Fecha</th>
                      <th width="10%">Editar</th>
                      <th width="10%">Eliminar</th>
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
  function estilo_tablas() {
    $('#lista_actividades').dataTable().fnDestroy();
    $('#lista_actividades').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
        "type": "POST",
        "url": "tabla_actividades.php",
        "dataSrc": "",
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Actividad" },
        { "data": "Fecha" },
        { "data": "Editar" },
        { "data": "Eliminar" },
      ]
    });
  }  
  $(function (){
   estilo_tablas();
  })
    $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar_actividad.php";
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: $('#form-datos').serialize(),
          success: function(respuesta) {
            if (respuesta=="ok") {
              alertify.success("Datos actualizados correctamente");
              $('#form-datos')[0].reset();
              estilo_tablas();
              $("#id_persona").select2("trigger", "select", {
                data: { id: '', text:'' }
              });
            }
          },
          error: function(xhr, status) {
            alert("error");
            //alert(xhr);
          },
        })
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $( document ).ready( function () {
      $( "#form-datos" ).validate( {
        rules: {
          id_persona: "required",
          actividad: "required",
          fecha: "required"
        },
        messages: {
          id_persona: "Campo requerido",
          actividad: "Campo requerido",
          fecha: "Campo requerido"
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
    function editar_registro(id){
      $.ajax({
        url: 'consulta_datos.php',
        type: "POST",
        dateType: "html",
        data: {'id':id},
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_actividad').val(id);
          $("#id_persona").select2("trigger", "select", {
            data: { id: array[0] , text: array[1] }
          });
          $('#actividad').val(array[2]);
          $('#fecha').val(array[3]);
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
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
            url: 'eliminar_registro.php',
            data: '&id='+ id,
            type: "POST",
            success: function(respuesta) {
              if (respuesta = "ok"){
                alertify.success("Registro Eliminado Correctamente");
                estilo_tablas();
              }else{
                alertify.error("Ha Ocurrido un Error");
              }
            }
          });
        } 
      });
    }
    function generar_pdf(){
      var usuario = $('#id_persona2').val();
      var fecha1  = $('#fecha3').val();
      var fecha2  = $('#fecha4').val();

      if(usuario != "" && fecha1 != "" && fecha2 != ""){
        cadena="pdf.php?usuario="+usuario+"&fecha1="+fecha1+"&fecha2="+fecha2;
        window.open(cadena, '_blank');
      }
    }
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
    $('#id_persona').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
         url: "consulta_usuarios.php",
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
    $('#id_persona2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
         url: "consulta_usuarios.php",
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
  </script>
</body>
</html>