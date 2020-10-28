<?php
  include '../global_seguridad/verificar_sesion.php';
  $fecha_nueva = date('d-m-Y');
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
        <div class="box box-danger" <?php echo $solo_lectura; ?>>
          <div class="box-header">
            <h3 class="box-title">Materiales | Pedido <span id="nombre_pedido"></span></h3>
          </div>
          <div class="box-body">
            <div id="form_datos2" style="display: none;">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">*Material</label>
                    <select name="material" id="material" class="form-control" style="width: 100%" onchange="llenar(this.value)"></select>
                    <input type="hidden" name="id_pedido" id="id_pedido" class="form-control" value="0">
                    <input type="hidden" name="id_detalle" id="id_detalle" class="form-control" value="0">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">*Cantidad</label>
                    <input name="cantidad" id="cantidad" class="form-control" onkeyup="verificar(this.value)">
                  </div>
                </div>
              </div>
            </div>
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="">*Nombre Pedido:</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del Pedido" value="<?php echo 'Pedido '.$nombre_sede.' '.$fecha_nueva;?>">
                  </div>
                </div>
              </div>
          </div>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="guardar">Generar Pedido</button>
            <button type="button" class="btn btn-warning" id="guardar_material" style="display: none;" disabled>Guardar Material</button>
            <button type="button" class="btn btn-danger" id="terminar_pedido" style="display: none;">Terminar Pedido</button>
            </form>
          </div>
        </div>
        <div class="box box-danger" id="lista" style="display: none">
          <div class="box-header">
            <h3 class="box-title">Materiales | Lista de Materiales</h3>
          </div>
          <div class="box-body">
            <div class="row">
             <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_pedido" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger" id="tabla">
          <div class="box-header">
            <h3 class="box-title">Materiales | Lista de Pedidos</h3>
          </div>
          <div class="box-body">
            <div class="row">
             <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_pedidos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Estatus</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        <th>PDF</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Estatus</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        <th>PDF</th>
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

<?php include '../footer.php';?>
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
    var id_pedido = $('#id_pedido').val();
    $('#lista_pedido').dataTable().fnDestroy();
    $('#lista_pedido thead th').each( function () {
      var title = $(this).text();
      $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%" />' );
    });
    var table = $('#lista_pedido').DataTable( {
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
          title: 'Bitacora Servicios',
          exportOptions: {
            columns: ':visible'
          }
        },
        {
          extend: 'pdf',
          text: 'Exportar a PDF',
          className: 'btn btn-default',
          title: 'Bitacora Servicios',
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
        "url": "tabla_detalle.php",
        "dataSrc": "",
        "data":{'id_pedido':id_pedido}
      },
      "columns": [
        { "data": "#", "width": "5%" },
        { "data": "Nombre" },
        { "data": "Descripcion" },
        { "data": "Cantidad", "width": "5%" },
        { "data": "Editar", "width": "5%" },
        { "data": "Eliminar", "width": "5%" }
      ]
    });
  }
  $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar_pedido.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta)
          {
            var array = eval(respuesta);
            if (array[0]=="ok") {
              alertify.success("Pedido Generado Correctamente");
              $('#form_datos')[0].reset();
              $('#form_datos').hide();
              $('#form_datos2').show();
              $('#guardar').hide();
              $('#guardar_material').show();
              $('#terminar_pedido').show();
              $('#lista').show();
              $('#id_pedido').val(array[1]);
              cargar_tabla2();
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
          nombre: "required"

        },
        messages: {
          nombre: "Campo requerido"
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
    $('#material').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
        url: "combo_materiales.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          var id_pedido = $('#id_pedido').val();
        return {
          searchTerm: params.term,
          id_pedido: id_pedido
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
    function llenar(id_material){
      $.ajax({
        type: "POST",
        url: 'data.php',
        data: {'id_material':id_material}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta == "0"){
            $('#cantidad').attr('placeholder',respuesta);
            alertify.error("No hay Piezas Disponibles");
          }else{
            $('#cantidad').attr('placeholder',respuesta);
          }
        }
      });
    }
    function verificar(cantidad){
      var limite = document.querySelector('#cantidad'); 
      if(cantidad == 0 || cantidad == ""){
        alertify.error("Ingresa un numero mayor a 0");
        $('#guardar_material').attr('disabled', true);
      }else if(cantidad <= parseInt(limite.placeholder)){
        $('#guardar_material').attr('disabled', false);
      }else{
        alertify.error("No tienes piezas suficientes");
        $('#guardar_material').attr('disabled', true);
      }
    }
    $('#guardar_material').click(function(){
      var material  = $('#material').val();
      var id_pedido = $('#id_pedido').val();
      var cantidad  = $('#cantidad').val();
      var id_detalle  = $('#id_detalle').val();
      $.ajax({
        type: "POST",
        url: 'registrar_pedido.php',
        data: {'material':material, 'id_pedido':id_pedido, 'cantidad':cantidad,'id_detalle':id_detalle}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta == "ok"){
            alertify.success("Material Añadido Correctamente");
            $('#material').attr('disabled',false);
            $("#material").select2("trigger", "select", {
              data: { id: '', text: '' }
            });
            $('#cantidad').val("");
            $('#id_detalle').val("0");
            cargar_tabla();
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
    });
    $('#terminar_pedido').click(function(){
      var id_pedido = $('#id_pedido').val();
      $.ajax({
        type: "POST",
        url: 'terminar_pedido.php',
        data: {'id_pedido':id_pedido}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta == "ok"){
            alertify.success("Pedido Terminado Correctamente");
            $('#form_datos').show();
            $('#form_datos2').hide();
            $('#guardar').show();
            $('#guardar_material').hide();
            $('#terminar_pedido').hide();
            $('#lista').hide();
            $('#id_pedido').val("0");
            cargar_tabla2();
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
    })
    function editar_detalle(id){
      $.ajax({
        type: "POST",
        url: 'editar_detalle.php',
        data: {'id':id}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          var array = eval(respuesta);
          $("#material").select2("trigger", "select", {
            data: { id: array[0], text:array[1]}
          });         
          $('#material').attr('disabled',true);
          $('#guardar_material').attr('disabled',false);
          $('#cantidad').val(array[2]);
          $('#id_detalle').val(id);
        }
      });
    }
    function eliminar_detalle(id){
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
            url: 'eliminar_detalle.php',
            data: {'id':id}, // Adjuntar los campos del formulario enviado.
            success: function(respuesta)
            {
              if(respuesta == "ok"){
                alertify.success("Se ha Eliminado Correctamente");
                cargar_tabla();
              }else{
                alertify.error("Ha Ocurrido un Error");
              }
            }
          });
        } 
      });
    }
    function editar_pedido(id){
      $.ajax({
        type: "POST",
        url: 'editar_pedido.php',
        data: {'id':id}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          var array = eval(respuesta);

          $('#form_datos').hide();
          $('#form_datos2').show();
          $('#id_pedido').val(id);
          cargar_tabla();
          $('#lista').show();
          $('#nombre_pedido').html(array[1]);
          $('#guardar').hide();
          $('#guardar_material').show();
          $('#terminar_pedido').show();
        }
      });
    }
    function eliminar_pedido(id){
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
            url: 'eliminar_pedido.php',
            data: {'id':id}, // Adjuntar los campos del formulario enviado.
            success: function(respuesta)
            {
              if(respuesta == "ok"){
                alertify.success("Se ha Eliminado Correctamente");
                cargar_tabla2();
              }else{
                alertify.error("Ha Ocurrido un Error");
              }
            }
          });
        } 
      });
    }
    function cargar_tabla2(){
      $('#lista_pedidos').dataTable().fnDestroy();
      $('#lista_pedidos').DataTable( {
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
            title: 'Bitacora Servicios',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Bitacora Servicios',
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
          "url": "tabla_pedidos.php",
          "dataSrc": "",
        },
        "columns": [
          { "data": "#", "width": "5%" },
          { "data": "Nombre"},
          { "data": "Estatus", "width": "5%" },
          { "data": "Editar", "width": "5%" },
          { "data": "Eliminar", "width": "5%" },
          { "data": "PDF", "width": "5%" }
        ]
      });
    }
    function mostrar_comentario(id){
      $.ajax({
        type: "POST",
        url: 'consulta_comentario.php',
        data: {'id':id}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          alertify.error(respuesta);
        }
      });
    }
    cargar_tabla2();
  </script>
</body>
</html>
