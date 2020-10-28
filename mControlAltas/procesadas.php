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
    <?php include 'menuV2.php'; ?>
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
          <h3 class="box-title">Lista de Altas en Proceso</h3>
          <div class="box-tools pull-right">
            <a onclick="estilo_tablas();">
              <i class="fa fa-refresh fa-spin"></i>
            </a>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista_altas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th width="10%">Clave SAT</th>
                      <th>Proveedor</th>
                      <th>Costo</th>
                      <th width="5%">Impuesto</th>
                      <th>Persona Procesó</th>
                      <th width="10%">Sucursal</th>
                      <th>Estatus</th>
                      <th width="5%">Imagen</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tr>
                   	<th width="5%">#</th>
                    <th width="10%">Clave SAT</th>
                    <th>Proveedor</th>
                    <th>Costo</th>
                    <th width="5%">Impuesto</th>
                    <th>Persona Procesó</th>
                    <th width="10%">Sucursal</th>
                    <th>Estatus</th>
                    <th width="5%">Imagen</th>
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
                <img src="" id="imagen_presentacion" width="300px" class="img-rounded zoom" style="display: none">
                <img src="" id="imagen_codigo" width="300px" class="img-rounded zoom" style="display: none">
              </center>
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
  function mostrar_desc(numero){
    if($('#desc'+numero).hasClass('hidden')){
      $('#desc'+numero).removeClass('hidden');
    }else{
      $('#desc'+numero).addClass('hidden');
    }
  }
  function estilo_tablas () {
   	$('#lista_altas').dataTable().fnDestroy();
    $('#lista_altas').DataTable( {
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
              title: 'Lista Procesadas',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Lista Procesadas',
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
            "url": "tabla_altas_procesadas.php",
            "dataSrc": "",
            "data":""
        },
        "columns": [
            { "data": "#" },
            { "data": "Clave SAT" },
            { "data": "Proveedor" },
            { "data": "Costo" },
            { "data": "Impuesto" },
            { "data": "PersonaP" },
            { "data": "Sucursal" },
            { "data": "Boton" },
            { "data": "Imagen" }
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
          
          $("#imagen_presentacion").show();
          $("#imagen_codigo").show();

          $("#imagen_presentacion").attr("src",imagen1);
          $("#imagen_codigo").attr("src",imagen2);
        }
      });
    }
    function liberar(id_registro){
      $.ajax({
        url: 'liberar_registro.php',
        data: '&id_registro='+ id_registro,
        type: "POST",
        success: function(respuesta) {
         estilo_tablas();
         $("#imagen_presentacion").attr("src","");
          $("#imagen_codigo").attr("src","");
        }
      });
    }
    function cancelar(id_registro){
      $.ajax({
        url: 'cancelar_registro.php',
        data: '&id_registro='+ id_registro,
        type: "POST",
        success: function(respuesta) {
         estilo_tablas();
        }
      });
    }
    function limpiar(){
      $("#imagen_presentacion").hide();
      $("#imagen_codigo").hide();
      $("#imagen_presentacion").attr("src","");
      $("#imagen_codigo").attr("src","");
    }
    function abrir_comentario(numero){
      $('#comentario'+numero).show();
    }
    function cambiar_estatus(comentario,id_registro,numero){
      var estatus = $('#estatus'+numero).val();
      if(comentario != ""){
         $.ajax({
          url: 'liberar_registro.php',
          data: {'id_registro':id_registro,'estatus':estatus,'comentario':comentario},
          type: "POST",
          success: function(respuesta) {
           estilo_tablas();
           llenar_notificaciones();
           $("#imagen_presentacion").attr("src","");
            $("#imagen_codigo").attr("src","");
          }
        });
      }
      else{
        alertify.error("Ingresa Comentario",2);
      }
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
  // $(function () {
  //   $('.select2').select2({
  //     placeholder: 'Seleccione una opcion',
  //     lenguage: 'es'
  //   })
  // })
</script>
</body>
</html>
