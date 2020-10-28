<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$id = $_GET['id'];

$cadena = "SELECT
	c.id,
	c.codigo,
	c.id_bodega,
	c.nombre,
	c.descripcion,
	c.activo,
	c.fecha,
	c.id_usuario,
	h.existencia
FROM
	catalago_materiales c
INNER JOIN historial_existencia_materiales h ON h.codigo = c.codigo
WHERE
	c.id = '$id'";

$consulta = mysqli_query($conexion, $cadena);
$row = mysqli_fetch_array($consulta);
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
    <?php include 'menuV.php'; ?>
  </aside>
  <div class="content-wrapper">
    <section class="content">
    	<div class="row">
          <div class="col-md-12">
            <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Calendario | Editar</h3>
          </div>
          <div class="box-body">
              <form method="POST" id="form_materiales_editar">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                          <label for="id">*Id</label>
                            <input type="text" name="id" id="id" value="<? echo $row[0];?>" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                          <label for="codigo">*Codigo</label>
                            <input type="text" name="codigo" id="codigo" value="<? echo $row[1];?>" class="form-control" readonly>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                          <label for="nombre">*Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="<? echo $row[3];?>" class="form-control">
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                          <label for="descripcion">*Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" value="<? echo $row[4];?>" class="form-control">
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">	
                            <label for="bodega">*Bodega</label>
                            <select name="bodega" id="bodega" style="width: 100%;" class="form-control select2">
                            <option value=""></option>
                            <?php
                            $cadena = "SELECT
                                            id,
                                            nombre
                                        FROM
                                            bodega
                                        WHERE
                                            activo = '1'";
                            $consulta = mysqli_query($conexion, $cadena);
                            while ($row1=mysqli_fetch_array($consulta))
                                {
                                    if ($row[2] == $row1[0])
                                        {
                                            echo "<option value=\"$row[2]\"selected>$row1[1]</option>";
                                        }
                                    else
                                        {
                                            echo "<option value=\"$row1[0]\">$row1[1]</option>";
                                        }
                                }?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                          <label for="existencia">*Existencia</label>
                            <input type="number" name="existencia" id="existencia" value="<? echo $row[8];?>" class="form-control">
                        </div>
                    </div>  
                </div>
                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-danger" id="guardar">Guardar</button>
                </div>
            </form> 
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
<script>
  function estilo_tablas () {
    $('#lista_plantillas').DataTable({
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
        var url = "update.php"; 
          $.ajax({
                 type: "POST",
                 url: url,
                 data: $("#form_materiales_editar").serialize(),
                 success: function(respuesta)
                 {
                    if(respuesta == 1)
                        {
                            alertify.error("Algunos Campos Estan Vacios.",2);
                            document.getElementById("nombre").focus();
                        }
                    else if(respuesta == 2)
                        {
                            location.href ="index.php";
                        }
                    else
                        {
                            alertify.error("Algo salio Mal.",2);    
                            $(":text").val('');
                            cargar_tabla();
                        }
                 }
               });
          return false;
      }
    });
    $( document ).ready( function () {
      $( "#form_materiales_editar" ).validate( {
        rules: {
          nombre: "required",
          descripcion: "required",
          bodega: "required",
          existencia: "required"
        },
        messages: {
          nombre: "Campo requerido",
          descripcion: "Campo requerido",
          bodega: "Campo requerido",
          existencia: "Campo requerido"
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
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  })
</script>
</body>
</html>