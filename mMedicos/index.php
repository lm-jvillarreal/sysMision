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
          <h3 class="box-title">Registro de Médicos</h3>
        </div>
        <div class="box-body">
          <form method="POST" id="form_datos">
            <div class="row">
             <div class="col-md-12">
                <div class="col-md-4">
                 <div class="form-group">
                  <input type="number" name="id_registro" id="id_registro" class="hidden">
                  <label for="id_persona">*Persona</label>
                  <select name="id_persona" id="id_persona" class="form-control select2">
                    <option value=""></option>
                  </select>
                 </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cedula">*Cédula Profesional</label>
                    <input type="text" name="cedula" id="cedula" class="form-control" placeholder="ej. 9900772">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="instituciones">*Institución que emite el titulo</label>
                    <input type="text" name="instituciones" id="instituciones" class="form-control" placeholder="ej. Universidad del Valle de México ">
                  </div>
                </div>
             </div>                                            
            </div> 
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="especialidad">*Especialidad</label>
                    <input type="text" name="especialidad" id="especialidad" class="form-control" placeholder="ej. Médico Partero" > 
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
          <h3 class="box-title">Lista de Médicos Existentes</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="lista_medicos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th>Nombre completo</th>
                      <th >Cédula</th>
                      <th >Institución</th>
                      <th >Espesialidad</th>
                      <th >Editar</th>
                      <th >Eliminar</th>
                    </tr>
                  </thead>
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
    var paciente = $("#Paciente").val();
    $('#lista_medicos').dataTable().fnDestroy();
    $('#lista_medicos').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   true,
        "order": [[0,"desc"]],
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
    "ajax": {
            "type": "POST",
            "url": "tabla_medicos.php",
            "dataSrc": "",
            "data":""
        },
        "columns": [
            { "data": "id" },
            { "data": "id_persona" },
            { "data": "cedula" },
            { "data": "instituciones" },
            { "data": "especialidad" },
            { "data": "editar" },
            { "data": "eliminar" }
        ]
    });
  }
  cargar_tabla();
    $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar_medico.php"; // El script a dónde se realizará la petición.
          $.ajax({
                 type: "POST",
                 url: url,
                 data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
                 success: function(respuesta)
                 {
                  if (respuesta=="ok") {
                    alertify.success("Registro guardado correctamente");
                    $("#id_persona").select2("trigger", "select", {
                      data: { id: '', text:''}
                    });
                    $(":text").val(''); //Limpiar los campos tipo Text
                    $('#id_registro').val("0");
                    cargar_tabla();
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
          id_persona: "required",
          cedula: "required",
          institucion: "required",
          especialidad: "required"
        },
        messages: {
          id_persona: "Campo requerido",
          cedula: "Campo requerido",
          institucion: "Campo requerido",
          especialidad: "campo requerido"
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
  </script>
  <script>
$(function () {
    $('#id_persona').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: "select_persona.php",
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
</script>
  <script>
    function eliminar(id_medico){
      swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: 'eliminar_medico.php',
            data: '&id_medico='+id_medico,
            type: "POST",
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success('Registro Eliminado');
                cargar_tabla();
              }
              else{
                alertify.error('Ha Ocurrido un Error');
              }
             }
          });
        } else {
          swal("No se ha eliminado el registro.",{
            icon: "error",
          });
        }
      });
    }
    function editar_registro(id){
      $.ajax({
        url: 'editar_medico.php',
        data: '&id='+ id,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);

          $('#id_registro').val(id);

          $("#id_persona").select2("trigger", "select", {
            data: { id: array[0], text:array[1]}
          });

          $('#cedula').val(array[2]);
          $('#instituciones').val(array[3]);
          $('#especialidad').val(array[4]);
        }
      });
    }
</script>
</body>
</html>
