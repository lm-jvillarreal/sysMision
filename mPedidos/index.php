<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_supsys.php';
$perfil = $_SESSION["sysAdMision_perfil"];
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-1,date('Y'))); 
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
      <div id="div_sistemas" style="display: none;">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Compras | Pedidos de articulos</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form-datos">
            <div class="row">
              <div class="col-md-2">
                <label>Nombre</label>
                <input type="text" name=""  id="nombre_catalogo" class="form-control">
                <input type="hidden" name="" id="id_caja">
              </div>
              <div class="col-md-3">
                <label>Lista</label>
                <select class="form-control" name="">
                  <option>Seleccione...</option>
                  <?php 
                    $sql = "SELECT CONCAT(id,' ',nombre) FROM catalogos_pedidos";
                    $exSql = mysqli_query($conexion, $sql);
                    while ($row = mysqli_fetch_row($exSql)) {
                      echo "<option>$row[0]</option>";
                    }
                   ?>
                </select>
              </div>
              <div class="col-md-3">
                <label>Archivo</label>
                <input type="file" name="">
              </div>
            </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <a href="#" onclick="javascript:crear_catalogo()" class="btn btn-danger">Guardar</a>
            <a href="rpt_analisis.php" class="btn btn-danger">Importar</a>
          </div>
        </div>
         <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Cajas de articulos | Detalle</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <div id="contenedor_tabla">
                      <?php include 'tabla_pedidos.php'; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>        
      </div>
      <div id="div_op">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de catalogos</h3>
            <br>
            <br>
                <div id="alta">
                  <?php 
                    $sql = "SELECT id, nombre FROM catalogos_pedidos WHERE activo = 1";
                    $exSql = mysqli_query($conexion, $sql);
                    while ($row = mysqli_fetch_row($exSql)) {?>
                          <a class="btn btn-primary" href="javascript:mostrar_catalogo(<?php echo $row[0] ?>)"><?php echo "$row[1]" ?></a>
                    <?}
                   ?>
                </div>
          </div>
          <div class="box-body">
            <div id="contenedor_tabla_detalle"></div>
          </div>
          <div class="box-footer"></div>
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
<!-- Page script -->
<script>




function modificar_descripcion(descripcion, codigo){
    $.ajax({
        data: {
            'descripcion': descripcion,
            'codigo': codigo
            
        }, //datos que se envian a traves de ajax
        url: 'modificar_descripcion.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
            
        }
    });
}

function agregar_articulo(codigo, id_caja, cantidad, descripcion) {
    $.ajax({
        data: {
            'codigo': codigo,
            'id_caja': id_caja,
            'cantidad': cantidad,
            'descripcion': descripcion
        }, //datos que se envian a traves de ajax
        url: 'agregar_articulo.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
            //$("#frmDatos")[0].reset();
            //blanco();
            //recargar_tabla(id_caja);
            recargar_tabla(id_caja);
        }
    });
}

function recargar_tabla(id_caja) {
    $.ajax({
        data: {
            'id_caja': id_caja
        }, //datos que se envian a traves de ajax
        url: 'tabla_contenido_caja.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
            $('#contenedor_tabla').html(response);
        }
    });
}

function crear_catalogo() {
    var nombre = $('#nombre_catalogo').val();
    $.ajax({
        url: "guardar_catalogo.php",
        type: "POST",
        dateType: "html",
        data: {
            "nombre": nombre
        },
        success: function(respuesta) {
            //(location.reload();
            alert(respuesta);
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}
  function mostrar_catalogo(id_catalogo) {
    $.ajax({
        url: "tabla_detalle_catalogo.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_catalogo': id_catalogo
        },
        success: function(respuesta) {
            $('#contenedor_tabla_detalle').html(respuesta);
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}


function mostrar(id_perfil) {
  if (perfil == 1) {

  }else{
    
  }
}
</script>

</body>
</html>
