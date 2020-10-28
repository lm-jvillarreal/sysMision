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
  <link rel="stylesheet" type="text/css" href="estilo_imagen.css">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Lista de Altas Liberadas</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <a onclick="estilo_tablas();">
              <i class="fa fa-refresh fa-spin"></i>
            </a>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista_liberadas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th>Proveedor</th>
                      <th>Comprador</th>
                      <th>Costo</th>
                      <th>IVA</th>
                      <th>IEPS</th>
                      <th>Fecha Proceso</th>
                      <th>Fecha Libero</th>
                      <th>Sucursal</th>
                      <th>Comentario</th>
                      <th>Imagen</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                   	<th width="5%">#</th>
                    <th>Proveedor</th>
                    <th>Comprador</th>
                    <th>Costo</th>
                    <th>IVA</th>
                    <th>IEPS</th>
                    <th>Fecha Proceso</th>
                    <th>Fecha Libero</th>
                    <th>Sucursal</th>
                    <th>Comentario</th>
                    <th>Imagen</th>
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
          <h3 class="box-title">Imagenes</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" onclick="limpiar()"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <center>
                <img src="" id="imagen_presentacion" class="img-rounded zoom" style="display: none">
                <img src="" id="imagen_codigo" class="img-rounded zoom" style="display: none">
              </center>
            </div>
          </div>
        </div>
      </div>
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Lista de Altas Canceladas</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <a onclick="estilo_tablas1();">
              <i class="fa fa-refresh fa-spin"></i>
            </a>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla1">
              <div class="table-responsive">
                <table id="lista_canceladas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th>Proveedor</th>
                      <th>Comprador</th>
                      <th>Costo</th>
                      <th>IVA</th>
                      <th>IEPS</th>
                      <th>Fecha Proceso</th>
                      <th>Fecha Canceló</th>
                      <th>Sucursal</th>
                      <th>Comentario</th>
                      <th>Imagen</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                    <th width="5%">#</th>
                    <th>Proveedor</th>
                    <th>Comprador</th>
                    <th>Costo</th>
                    <th>IVA</th>
                    <th>IEPS</th>
                    <th>Fecha Proceso</th>
                    <th>Fecha Canceló</th>
                    <th>Sucursal</th>
                    <th>Comentario</th>
                    <th>Imagen</th>
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
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  })
</script>
<script>
  function estilo_tablas () {
   	$('#lista_liberadas').dataTable().fnDestroy();
    $('#lista_liberadas').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "ajax": {
            "type": "POST",
            "url": "tabla_altas_liberadas.php",
            "dataSrc": "",
            "data":""
        },
        "columns": [
            { "data": "#" },
            { "data": "Proveedor" },
            { "data": "Comprador" },
            { "data": "Costo" },
            { "data": "IVA" },
            { "data": "IEPS" },
            { "data": "FechaP" },
            { "data": "FechaL" },
            { "data": "Sucursal" },
            { "data": "Comentario" },
            { "data": "Imagen" },
        ]
    });
   }  
  $(function (){
   estilo_tablas();
  })
    $.validator.setDefaults( {
      submitHandler: function () {
        var f = $(this);
        var formData = new FormData(document.getElementById("form_datos"));
        formData.append("dato", "valor");
        //formData.append(f.attr("name"), $(this)[0].files[0]);
       	$.ajax({
          type: "POST",
          url: 'insertar_alta.php',
          dataType: "html",
          data: formData,
          cache: false,
          contentType: false,
  	     	processData: false
  		  })
        .done(function(res){
          if (res == "ok"){
            alertify.success("Registros Guardados Correctamente");
            location.reload();
          }
          else if(res == "duplicado"){
            alertify.error("Ya Existe un Registro");
          }
          else{
            alertify.error("Ha Ocurrido un Error");
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $( document ).ready( function () {
      $( "#form_datos" ).validate( {
        rules: {
          proveedor: "required",
          comprador: "required",
          costo: "required"
        },
        messages: {
          proveedor: "Campo requerido",
          comprador: "Campo requerido",
          costo: "Campo requerido"
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
  <script type="text/javascript">
    function mostrar_imagenes(id_registro){
      $.ajax({
        url: 'imagenes.php',
        data: '&id_registro='+ id_registro,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          imagen1   = array[0];
          imagen2   = array[1];
          $("#imagen_presentacion").attr("src",imagen1);
          $("#imagen_codigo").attr("src",imagen2);
        }
      });
    }
    function estilo_tablas1() {
    $('#lista_canceladas').dataTable().fnDestroy();
    $('#lista_canceladas').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "ajax": {
            "type": "POST",
            "url": "tabla_altas_canceladas.php",
            "dataSrc": "",
            "data":""
        },
        "columns": [
            { "data": "#" },
            { "data": "Proveedor" },
            { "data": "Comprador" },
            { "data": "Costo" },
            { "data": "IVA" },
            { "data": "IEPS" },
            { "data": "FechaP" },
            { "data": "FechaL" },
            { "data": "Sucursal" },
            { "data": "Comentario" },
            { "data": "Imagen" },
        ]
    });
   }  
  $(function (){
   estilo_tablas1();
  });
  function mostrar_imagenes(id_registro){
    $.ajax({
      url: 'imagenes.php',
      data: '&id_registro='+ id_registro,
      type: "POST",
      success: function(respuesta) {
        var array = eval(respuesta);
        imagen1   = array[0];
        imagen2   = array[1];
        
        $("#imagen_presentacion").show();
        $("#imagen_codigo").show();

        $("#imagen_presentacion").attr("src",imagen1);
        $("#imagen_codigo").attr("src",imagen2);
      }
    });
  }
  function limpiar(){
    $("#imagen_presentacion").hide();
    $("#imagen_codigo").hide();
    $("#imagen_presentacion").attr("src","");
    $("#imagen_codigo").attr("src","");
  }
  </script>
  <script>
  $(document).ready(function(){
    $('.zoom').hover(function() {
      $(this).addClass('transition');
    }, function() {
      $(this).removeClass('transition');
    });
  });
</script>
</body>
</html>
