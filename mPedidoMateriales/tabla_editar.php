<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
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
  <aside class="main-sidebar">
    <?php include 'menuV2.php'; ?>
  </aside>
  <div class="content-wrapper">
    <section class="content">
        <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Lista de Materiales</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
	                  <th>Folio</th>
	                  <th>Fecha</th>
                      <th>Sucursal</th>
	                  <th>Usuario</th>
                      <th>Editar</th>
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
    </section>
  </div>
  <?php include '../footer2.php'; ?>
  <div class="control-sidebar-bg"></div>
</div>
<?php include '../footer.php'; ?>
<script src="funciones.js"></script>
<script>cargar_tabla();</script>
<script>
  function estilo_tablas () {
    $('#lista').DataTable({
      'paging'    : true,
      'lengthChange'  : true,
      'searching'   : true,
      'ordering'    : true,
      'info'      : true,
      'autoWidth'   : false,
      'language'    : {"url": "../plugins/DataTables/Spanish.json"}
    })
   }
    $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar.php"; 
          $.ajax({
                 type: "POST",
                 url: url,
                 data: $("#form_pedidos").serialize(),
                 success: function(respuesta)
                 {                     
                    if(respuesta == 1)
                        {
                            alertify.error("Algunos Campos Estan Vacios.",2);
                            document.getElementById("nombre").focus();
                        }
                    else if(respuesta == 2)
                        {
                           alertify.success("Se Guardo Exitosamente.",2);
                           CargarFolio();
                           CargarBodega();
                        }
                    else
                        {
                            alertify.error("El pedido ya se realizo a las: "+respuesta,4);
                        }
                 }
               });
          return false;
      }
    });
    $( document ).ready( function () {
      $( "#form_pedidos" ).validate( {
        rules: {
          bodega: "required"
        },
        messages: {
          bodega: "Campo requerido"
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) 
          {
              error.addClass( "help-block" );
              if ( element.prop( "type" ) === "checkbox" ) 
                  {
                    error.insertAfter( element.parent( "label" ) );
                  } 
              else 
                  {
                    error.insertAfter( element );
                   }
          },
        highlight: function ( element, errorClass, validClass ) 
          {
            $( element ).parents( ".col-md-2" ).addClass( "has-error" ).removeClass( "has-success" );
            $( element ).parents( ".col-md-4" ).addClass( "has-error" ).removeClass( "has-success" );
            $( element ).parents( ".col-md-6" ).addClass( "has-error" ).removeClass( "has-success" );
            $( element ).parents( ".col-md-8" ).addClass( "has-error" ).removeClass( "has-success" );
            $( element ).parents( ".col-md-10" ).addClass( "has-error" ).removeClass( "has-success" );
            $( element ).parents( ".col-md-12" ).addClass( "has-error" ).removeClass( "has-success" );
          },
        unhighlight: function (element, errorClass, validClass) 
          {
            $( element ).parents( ".col-md-2" ).addClass( "has-success" ).removeClass( "has-error" );
            $( element ).parents( ".col-md-4" ).addClass( "has-success" ).removeClass( "has-error" );
            $( element ).parents( ".col-md-6" ).addClass( "has-success" ).removeClass( "has-error" );
            $( element ).parents( ".col-md-8" ).addClass( "has-success" ).removeClass( "has-error" );
            $( element ).parents( ".col-md-10" ).addClass( "has-success" ).removeClass( "has-error" );
            $( element ).parents( ".col-md-12" ).addClass( "has-success" ).removeClass( "has-error" );
          }
      });
    });
</script>
<script>
    $(function(){
      $('.select2').select2({
        placeholder:"Seleccione una opcion"
      });
    });
</script>
<script type="text/javascript">
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