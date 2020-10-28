<?php
include '../global_seguridad/verificar_sesion.php';
$id_orden = $_GET['id'];

$cadena_orden_compra = "SELECT
          proveedores.numero_proveedor,
          proveedores.proveedor,
          orden_compra.orden_compra,
          orden_compra.id,
          sucursales.id,
          sucursales.nombre,
          proveedores.id
        FROM
          orden_compra
          INNER JOIN proveedores ON orden_compra.id_proveedor = proveedores.numero_proveedor
          INNER JOIN sucursales ON orden_compra.id_sucursal = sucursales.id
          WHERE orden_compra.id = '$id_orden'";

$consulta_orden_compra = mysqli_query($conexion, $cadena_orden_compra);
$row_orden_compra = mysqli_fetch_array($consulta_orden_compra);

$numero_proveedor = $row_orden_compra[0];
$nombre_proveedor = $row_orden_compra[1];
$orden_compra = $row_orden_compra[2];
$id_orden = $row_orden_compra[3];
$id_sucursal = $row_orden_compra[4];
$nombre_sucursal = $row_orden_compra[5];
$id_proveedor = $row_orden_compra[6];
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <form action="insertar_carta_faltante.php" method="POST" id="form-datos">
    	<div class="row">
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Órdenes de Compra | Detalles de la Orden de Compra</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                	<label>N° de Orden de Compra: <?php echo $orden_compra; ?></label>
                <br>
                <label>Proveedor: <?php echo $numero_proveedor; ?> - <?php echo $nombre_proveedor; ?></label>
                </div>
                <input type="hidden" name="id_proveedor" id="id_proveedor" value="<?php echo $id_proveedor; ?>">
                <input type="hidden" name="numero_proveedor" id="numero_proveedor" value="<?php echo $numero_proveedor; ?>">
                <input type="hidden" name="nombre_proveedor" id="nombre_proveedor" value="<?php echo $nombre_proveedor; ?>">
                <input type="hidden" name="orden_compra" id="orden_compra" value="<?php echo $orden_compra; ?>">
                <input type="hidden" name="id_orden" id="id_orden" value="<?php echo $id_orden; ?>">
                <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $id_sucursal; ?>">
                <input type="hidden" name="nombre_sucursal" id="nombre_sucursal" value="<?php echo $nombre_sucursal; ?>">
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label for="nombre_chofer">*Transportista</label>
                  <input type="text" name="nombre_chofer" id="nombre_chofer" class="form-control" required="true" maxlength="21">
                </div>
                <div class="col-md-6">
                  <label for="tipo_carta">*Tipo de Carta</label>
                  <select name="tipo_carta" id="tipo_carta" class="form-control select2" required="true">
                    <option value=""></option>
                    <option value="FALTANTE">Carta Faltante</option>
                    <option value="SOBRANTE">Carta Sobrante</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Carta Faltante | Detalles</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-1">
                  <label for="cantidad">*Activar</label>
                </div>
                <div class="col-md-2">
                  <label for="cantidad">*Cantidad</label>
                </div>
                <div class="col-md-7">
                  <label for="descripcion">*Descripción</label>
                </div>
                <div class="col-md-2">
                  <label for="unidad_medida">U.M.</label>
                </div>
              </div>
              <?php
              for ($i=1; $i <= 20; $i++) { 
              ?>
                <div class="row">
                  <div class="col-md-1 text-center">
                    <input type="checkbox" name="activar[]" id="activar<?php echo $i ?>" onchange="validar_renglon(<?php echo $i ?>)">
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="number" step="any" name="cantidad[]" id="cantidad<?php echo $i ?>" class="form-control" disabled="disabled">
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="form-group">
                      <input type="text" name="descripcion[]" id="descripcion<?php echo $i ?>" class="form-control" disabled="disabled">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <select name="unidad_medida[]" id="unidad_medida<?php echo $i ?>" class="form-control select2" disabled="disabled">
                        <option value=""></option>
                        <option value="pieza">Pieza</option>
                        <option value="caja">Caja</option>
                        <option value="kg">Kilogramos</option>
                      </select>
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
            <div class="box-footer text-right">
              <button class="btn btn-danger" id="guardar">Guardar Carta Faltante</button>
            </div>
          </div>
        </div>
      </div>
      </form>
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
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    })
  })
</script>
<script>
  function validar_renglon(no_renglon){
    if($("#activar"+no_renglon).is(":checked")) {
      $("#cantidad"+no_renglon).removeAttr("disabled");
      $("#cantidad"+no_renglon).attr("required","true");
      $("#descripcion"+no_renglon).removeAttr("disabled");
      $("#descripcion"+no_renglon).attr("required","true");
      $("#unidad_medida"+no_renglon).removeAttr("disabled");
      $("#unidad_medida"+no_renglon).attr("required","true");
    }else{
      $("#cantidad"+no_renglon).removeAttr("required");
      $("#cantidad"+no_renglon).attr("disabled","disabled");
      $("#descripcion"+no_renglon).removeAttr("required");
      $("#descripcion"+no_renglon).attr("disabled","disabled");
      $("#unidad_medida"+no_renglon).removeAttr("required");
      $("#unidad_medida"+no_renglon).attr("disabled","disabled");
    }
  }
</script>
</body>
</html>
