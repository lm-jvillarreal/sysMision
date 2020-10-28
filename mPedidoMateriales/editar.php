<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$folio = $_GET["id"];

$cadena_tabla = "SELECT
                    h.id,
                    h.folio,
                    h.id_bodega,
                    b.nombre,
                    h.codigo,
                    c.nombre,
                    c.descripcion,
                    h.pedido,
                    h.fecha,
                    h.id_usuario,
                    CONCAT(
                        p.nombre,
                        ' ',
                        p.ap_paterno,
                        ' ',
                        p.ap_materno
                    ) AS persona,
                    he.existencia
                FROM
                    historial_pedido_materiales h
                INNER JOIN bodega b ON b.id = h.id_bodega
                INNER JOIN catalago_materiales c ON c.codigo = h.codigo
                INNER JOIN historial_existencia_materiales he ON he.codigo = h.codigo
                INNER JOIN usuarios u ON u.id = h.id_usuario
                INNER JOIN personas p ON p.id = u.id_persona
                WHERE
                    h.folio = '$folio'";
$consulta_tabla = mysqli_query($conexion, $cadena_tabla);
$cadena_tabla1 = "SELECT
                    h.id,
                    h.folio,
                    h.id_bodega,
                    b.nombre,
                    h.codigo,
                    c.nombre,
                    c.descripcion,
                    h.pedido,
                    h.fecha,
                    h.id_usuario,
                    CONCAT(
                        p.nombre,
                        ' ',
                        p.ap_paterno,
                        ' ',
                        p.ap_materno
                    ) AS persona,
                    he.existencia
                FROM
                    historial_pedido_materiales h
                INNER JOIN bodega b ON b.id = h.id_bodega
                INNER JOIN catalago_materiales c ON c.codigo = h.codigo
                INNER JOIN historial_existencia_materiales he ON he.codigo = h.codigo
                INNER JOIN usuarios u ON u.id = h.id_usuario
                INNER JOIN personas p ON p.id = u.id_persona
                WHERE
                    h.folio = '$folio'";
$consulta_tabla1 = mysqli_query($conexion, $cadena_tabla1);
$row1=mysqli_fetch_array($consulta_tabla1);
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
            <h3 class="box-title">Pedidos | Filtros</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_editar_pedidos">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                          <label for="folio">*Folio</label>
                            <input  name="folio" id="folio" value="<?php echo "$row1[1]"; ?>" class="form-control" readonly>
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                          <label for="bodega">*Bodega</label>
                            <input  name="bodegaa" id="bodegaa" value="<?php echo "$row1[3]"; ?>" class="form-control" readonly>
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                          <label for="fecha">*Fecha</label>
                            <input  name="fecha" id="fecha" value="<?php echo "$row1[8]"; ?>" class="form-control" readonly>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table id="lista" class="table table-striped table-bordered" cellspacing="0" width="150%">
                            <thead>
                                <tr>
                                    <th width="2%">#</th>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Existencia</th>
                                    <th>Pedido</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $n = 1;
                            while($row=mysqli_fetch_array($consulta_tabla))
                                {?>
                                    <tr>
                                        <td>
                                            <center><?php echo "$n"; ?></center>
                                        </td>
                                        <td>
                                            <center><input type="text" class="form-control" style="border:none" id="codigo<?php echo $n;?>" name="codigo[]" readonly value="<?php echo "$row[4]"; ?>"></center>
                                        </td>
                                        <td>
                                            <center><input type="text" class="form-control" style="border:none" id="nombre<?php echo $n;?>" name="nombre[]" disabled value="<?php echo "$row[5]"; ?>"></center>
                                        </td>
                                        <td>
                                            <center><input type="text" class="form-control" style="border:none" id="descripcion<?php echo $n;?>" name="descripcion[]" disabled value="<?php echo "$row[6]"; ?>"></center>       
                                        </td>
                                        <td>
                                            <center><input type="text" class="form-control" style="border:none" id="existencia<?php echo $n;?>" name="existencia[]" disabled value="<?php echo "$row[11]"; ?>"></center>
                                        </td>
                                        <td>
                                            <center><input class="form-control" type="number" id="pedido<?php echo $n;?>" name="pedido[]" min="0" max="999" value="<?php echo "$row[7]"; ?>" onchange="javascript:validar2('<?php echo $n;?>',$('#codigo'+<? echo $n ?>).val(),$('#existencia'+<? echo $n ?>).val(),this.value,'<?php echo $row1[2];?>');"></center>
                                        </td>
                                    </tr>
                                 <?php 
                                 $n++;
                                 }
                                 ?>
                            </tbody>  
                        </table>
                    </div>        
                </div>
                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-danger" id="guardar">Guardar</button>
                </div>
            </form>  
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
                 data: $("#form_editar_pedidos").serialize(),
                 success: function(respuesta)
                 {                     
                    if(respuesta == 1)
                        {
                            alertify.error("Algunos Campos Estan Vacios.",2);
                            document.getElementById("nombre").focus();
                        }
                    else if(respuesta == 2)
                        {
                           location.href ="tabla_editar.php";
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
      $( "#form_editar_pedidos" ).validate( {
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