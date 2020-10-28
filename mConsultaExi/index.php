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
      <div class="box box-danger" id="tabla_principal">
        <div class="box-header">
          <h3 class="box-title">Consulta de Existencia | Lista</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista_proveedores" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Código</th>
                      <th>Familia</th>
                      <th>Descripción</th>
                      <th>Almacen</th>
                      <th>Rack</th>
                      <th>Columna</th>
                      <th>Fila</th>
                      <th>Cantidad</th>
                      <th>Foto</th>
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
  function cargar_tabla() {
      $('#lista_proveedores').dataTable().fnDestroy();
      $('#lista_proveedores thead th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%" />' );
      });
      var table = $('#lista_proveedores').DataTable( {
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
          "url": "tabla.php",
          "dataSrc": ""
        },
        "columns": [
          { "data": "#", "width":"3%" },
          { "data": "Codigo"},
          { "data": "Familia" },
          { "data": "Descripcion"},
          { "data": "Almacen"},
          { "data": "Rack"},
          { "data": "Columna"},
          { "data": "Fila"},
          { "data": "Cantidad"},
          { "data": "Foto"}
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
  cargar_tabla();
  $.validator.setDefaults( {
    submitHandler: function () {
      $.ajax({
        type: "POST",
        url: 'guardar.php',
        data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta=="ok") {
            alertify.success("Registro guardado correctamente");
            $('#form_datos')[0].reset();
            cargar_tabla();
          }else if(respuesta=="duplicado"){
            alertify.error("El registro ya existe");
          }else if(respuesta=="vacio"){
            alertify.error("Verifica Campos");
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
        razon_social: "required",
        t_empresa: "required",
        n_vendedor: "required",
        c_vendedor: "required",
        correo_vendedor: "required",
        n_supervisor: "required",
        c_supervisor: "required",
        correo_supervisor: "required"
      },
      messages: {
        nombre: "Campo requerido",
        razon_social: "Campo requerido",
        t_empresa: "Campo requerido",
        n_vendedor: "Campo requerido",
        c_vendedor: "Campo requerido",
        correo_vendedor: "Campo requerido",
        n_supervisor: "Campo requerido",
        c_supervisor: "Campo requerido",
        correo_supervisor: "Campo requerido"
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
  function eliminar(id){
    swal({
      title: "¿Está Seguro de Eliminar Registro?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar.php',
          data: {'id':id} ,
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
      }
    });
  }
  function editar(id){
    $.ajax({
      url: 'editar.php',
      data: {'id':id},
      type: "POST",
      success: function(respuesta) {
        var array = eval(respuesta);
        $('#id_registro').val(id);
        $('#nombre').val(array[0]);
        $('#razon_social').val(array[1]);
        $('#t_empresa').val(array[2]);
        $('#n_vendedor').val(array[3]);
        $('#c_vendedor').val(array[4]);
        $('#correo_vendedor').val(array[5]);
        $('#n_supervisor').val(array[6]);
        $('#c_supervisor').val(array[7]);
        $('#correo_supervisor').val(array[8]);
        $('#limpiar').attr('disabled',false);
      }
    });
  }
  function ver(id){
    $.ajax({
      url: 'editar.php',
      data: {'id':id},
      type: "POST",
      success: function(respuesta) {
        var array = eval(respuesta);
        $('#id_registro').val(id);
        $('#nombre').val(array[0]);
        $('#razon_social').val(array[1]);
        $('#t_empresa').val(array[2]);
        $('#n_vendedor').val(array[3]);
        $('#c_vendedor').val(array[4]);
        $('#correo_vendedor').val(array[5]);
        $('#n_supervisor').val(array[6]);
        $('#c_supervisor').val(array[7]);
        $('#correo_supervisor').val(array[8]);
        $('#limpiar').attr('disabled',false);
        $('#guardar').attr('disabled',true);
      }
    });
  }
  $('#limpiar').click(function(){
    $('#form_datos')[0].reset();
    $('#limpiar').attr('disabled',true);
    $('#guardar').attr('disabled',false);
  })
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
