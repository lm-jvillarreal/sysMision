<?php
include '../global_seguridad/verificar_sesion.php';
$id_carta_faltante = $_GET['id'];

$cadena_orden_compra = "SELECT
          carta_faltante.id,
          carta_faltante.id_orden,
          carta_faltante.no_orden,
          carta_faltante.tipo_orden,
          carta_faltante.numero_proveedor,
          proveedores.proveedor,
          carta_faltante.no_factura,
          sucursales.id,
          sucursales.nombre,
          carta_faltante.transportista,
          carta_faltante.total_diferencia,
          carta_faltante.bodeguero,
          carta_faltante.id_proveedor
        FROM
          carta_faltante
          INNER JOIN proveedores ON carta_faltante.id_proveedor = proveedores.id
          INNER JOIN sucursales ON carta_faltante.id_sucursal = sucursales.id
          WHERE carta_faltante.id = '$id_carta_faltante'";

$consulta_orden_compra = mysqli_query($conexion, $cadena_orden_compra);
$row_orden_compra = mysqli_fetch_array($consulta_orden_compra);

$id_carta = $row_orden_compra[0];
$id_orden = $row_orden_compra[1];
$orden_compra = $row_orden_compra[2];
$tipo_carta = $row_orden_compra[3];
$numero_proveedor = $row_orden_compra[4];
$nombre_proveedor = $row_orden_compra[5];
$id_sucursal = $row_orden_compra[7];
$no_factura = $row_orden_compra[6];
$nombre_sucursal = $row_orden_compra[8];
$nombre_transportista = $row_orden_compra[9];
$bodeguero=$row_orden_compra[11];
$id_proveedor=$row_orden_compra[12];
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
        <div class="row">
          <div class="col-md-12">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Órdenes de Compra | Detalles de la Orden de Compra</h3>
              </div>
              <div class="box-body">
                <form method="POST" id="form-datos">
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
                    <input type="hidden" name="nombre_transportista" id="nombre_transportista" value="<?php echo $nombre_transportista; ?>">
                    <input type="hidden" name="id_carta" id="id_carta" value="<?php echo $id_carta; ?>">
                    <input type="hidden" name="no_factura" id="id_carta" value="<?php echo $no_factura; ?>">
                    <input type="hidden" name="bodeguero" id="bodeguero" value="<?php echo $bodeguero; ?>">
                    <input type="hidden" name="comentario_cancela" id="comentario_cancela">
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label>Transportista: <?php echo $nombre_transportista ?></label>
                    </div>
                    <div class="col-md-6">
                      <label>Tipo de Carta: <?php echo $tipo_carta ?></label>
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
                  <div class="col-md-2">
                    <label for="cantidad">*Cantidad</label>
                  </div>
                  <div class="col-md-4">
                    <label for="descripcion">*Descripción</label>
                  </div>
                  <div class="col-md-2">
                    <label for="unidad_medida">U.M.</label>
                  </div>
                  <div class="col-md-2">
                    <label for="costo_unitario" style="display:none">C.U.</label>
                  </div>
                  <div class="col-md-2">
                    <label for="costo_total" style="display:none">C.T.</label>
                  </div>
                </div>
                <?php
                $cadena_detalle = "SELECT id, cantidad_producto, descripcion, unidad_medida, costo_unitario, total_renglon FROM detalle_carta_faltante WHERE id_carta_faltante = '$id_carta'";
                $consulta_detalle = mysqli_query($conexion, $cadena_detalle);
                while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
                  ?>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <input type="hidden" name="ide[]" id="ide" value="<?php echo $row_detalle[0] ?>">
                        <input type="number" step="any" name="cantidad[]" id="cantidad<?php echo $row_detalle[0] ?>" class="form-control" value="<?php echo $row_detalle[1] ?>" onkeyup="total_renglon(<?php echo $row_detalle[0] ?>);">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <input type="text" name="descripcion[]" id="descripcion" class="form-control" value="<?php echo $row_detalle[2] ?>">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <select name="unidad_medida[]" class="form-control select2">
                          <option value="<?php echo $row_detalle[3] ?>"><?php echo $row_detalle[3] ?></option>
                          <option value="Pieza">Pieza</option>
                          <option value="Caja">Caja</option>
                          <option value="Kg">Kilogramos</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <input type="number" step="any" name="costo_unitario[]" id="costo_unitario<?php echo $row_detalle[0] ?>" class="form-control" value="<?php echo $row_detalle[4] ?>" onkeyup="total_renglon(<?php echo $row_detalle[0] ?>);" style="display:none">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <input type="number" step="any" name="total_renglon[]" id="costo_total<?php echo $row_detalle[0] ?>" value="<?php echo $row_detalle[5] ?>" class="form-control" readonly style="display:none">
                      </div>
                    </div>
                  </div>
                <?php
                }
                ?>
                <div class="row">
                  <div class=" col-md-1 col-md-offset-9 text-right">
                    <label for="" style="display:none">Total Carta:</label>
                  </div>
                  <div class="col-md-2">
                    <input type="number" step="any" class="form-control" name="total_carta" id="total_carta" value="<?php echo $row_orden_compra[10] ?>" style="display:none">
                  </div>
                </div>
                </form>
              </div>
              <div class="box-footer">
                <div class="row">
                  <div class="col-md-4">
                    <button class="btn btn-warning" id="btnAgregar">Agregar artículo</button>
                  </div>
                  <div class="col-md-8 text-right">
                    <button class="btn btn-danger" id="guardar">Actualizar Carta Faltante</button>
                  </div>
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
  <!-- Page script -->
  <script>
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });

    function total_renglon(id) {
      //alert ("hola");
      var cantidad = parseFloat($('#cantidad' + id).val());
      var costo_unitario = parseFloat($('#costo_unitario' + id).val());
      var total = cantidad * costo_unitario;
      $('#costo_total' + id).val(total.toFixed(2));
    }
    $("#btnAgregar").click(function() {
      swal("Ingresa descripción de artículo:", {
          content: "input",
        })
        .then((value) => {
          //swal(`You typed: ${value}`);
          var id_carta = $("#id_carta").val();
          var url = 'agregar_articulo.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {
              id_carta: id_carta,
              articulo: `${value}`
            },
            success: function(respuesta) {
              location.reload();
            },
            error: function(xhr, status) {
              alert("error");
              //alert(xhr);
            },
          });
        });
      return false;
    });
    $("#guardar").click(function() {
      swal("Ingresa el comentario de modificación:", {
          content: "input",
        })
        .then((value) => {
          //swal(`You typed: ${value}`);
          $("#comentario_cancela").val(value);
          var url = 'actualizar_detalle_faltante.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: $('#form-datos').serialize(),
            success: function(respuesta) {
              if(respuesta=="no"){
                swal("Error de datos","Debes ingresar un comentario","error");
              }else{
                //window.open('carta_faltante_pdf.php?id='+respuesta, '_blank');
                window.location.href = 'index.php';
              }
            },
            error: function(xhr, status) {
              alert("error");
              //alert(xhr);
            },
          });
        });
      return false;
    });
  </script>
</body>

</html>