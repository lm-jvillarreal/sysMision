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
    <?php include 'menuV3.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Registro de Modelos</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="numero_serie">*Marca</label>
                    <input type="number" name="id_modelo" id="id_modelo" value="0" class="hidden">
                    <select id="marca" name="marca" class="form-control"></select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="numero_modelo">*Número de Modelo</label>
                    <input type="text" name="numero_modelo" id="numero_modelo" class="form-control" placeholder="Numero de Modelo">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="numero_modelo">*Tipo</label>
                    <select id="tipo" name="tipo" class="form-control">
                      <option value="1">PINPAD</option>
                      <option value="2">DUAL-UP</option>
                      <option value="3">GPRS</option>
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
            <h3 class="box-title">Lista de Modelos Existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_modelos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Tipo</th>
                        <th>Editar</th>
                        <th width="20%">Eliminar</th>
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
    $('#lista_modelos').dataTable().fnDestroy();
    $('#lista_modelos').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
        "type": "POST",
        "url": "tabla_modelos.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "#" },
        { "data": "Marca" },
        { "data": "Modelo" },
        { "data": "Tipo" },
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
        var url = "insertar_modelo.php"; // El script a dónde se realizará la petición.
          $.ajax({
            type: "POST",
            url: url,
            data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
            success: function(respuesta)
            {
              if (respuesta=="ok") {
                alertify.success("Modelo guardado correctamente");
                $(':text').val("");
                $("#marca").select2("trigger", "select", {
                  data: { id: '', text:'' }
                });
                estilo_tablas();
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
          marca: "required",
          numero_modelo: "required",
          tipo: "required"
        },
        messages: {
          marca: "Campo requerido",
          numero_modelo: "Campo requerido",
          tipo: "Campo requerido"
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
    $(function () {
    $('#marca').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
       url: "combos_marcas.php",
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
            url: 'eliminar_modelo.php',
            data: '&id='+id ,
            type: "POST",
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success('Marca Eliminada');
                estilo_tablas();
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
  function editar_marca(id_modelo){
    $.ajax({
      url: 'editar_modelo.php',
      data: '&id_modelo='+ id_modelo,
      type: "POST",
      success: function(respuesta) {
        var array = eval(respuesta);
        id_marca = array[0];
        marca    = array[1];
        modelo   = array[2];
        tipo     = array[3];
        
        $("#marca").select2("trigger", "select", {
          data: { id: id_marca, text:marca }
        });
        $('#tipo').val(tipo);
        $('#numero_modelo').val(modelo);
        $('#id_modelo').val(id_modelo);
      }
    });
  }
  </script>
</body>
</html>
