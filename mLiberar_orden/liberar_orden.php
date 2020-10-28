<?php
include '../global_seguridad/verificar_sesion.php';
$id_orden = $_GET['id_orden'];

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
$prefijo_fecha = date('y') . date('m') . date('d');
$prefijo = $id_sucursal . $prefijo_fecha;

$cadena_nota = "SELECT count(DISTINCT(numero_nota))+1 FROM libro_diario WHERE numero_nota like '$prefijo%'";
$consulta_nota = mysqli_query($conexion, $cadena_nota);
$row_nota = mysqli_fetch_array($consulta_nota);
$numero_nota = $prefijo . $row_nota[0];
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
        <form action="" method="POST" id="form-datos">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Órdenes de Entrada | Detalles de la Orden de Entrada</h3>
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
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Órdenes de Entrada | Datos del Recibo</h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="no_ficha">N° de Ficha:</label>
                        <input type="number" class="form-control" id="no_ficha" name="no_ficha" readonly="true" value="<?php echo $numero_nota; ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="no_factura">N° de Factura:</label>
                        <input type="text" name="no_factura" id="no_factura" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="total">Total:</label>
                        <input type="number" class="form-control" id="total" name="total">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <label for="observaciones">Observaciones:</label>
                      <input type="text" name="observaciones" id="observaciones" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="">¿Desea anexar Carta Faltante - Sobrante?</label>
                        <div class="radio">
                          <label>
                            <input type="radio" class="minimal-red" name="completo" id="completo_si" value="si">
                            Si
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" class="minimal-red" name="completo" id="completo_no" value="no">
                            No
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="box-footer text-right">
                  <button class="btn btn-danger" id="guardar">Liberar</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <?php include 'modal_escarg.php'; ?>
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
    $('input[type="file"]').filestyle({
      'text': 'Seleccionar',
      'btnClass': 'btn-danger'
    });

    $('input[type="radio"].minimal-red').iCheck({
      radioClass: 'iradio_minimal-red'
    });

    $("#guardar").click(function() {
      var completo = $("input[name=completo]:checked").val();
      var id_proveedor = $("#id_proveedor").val();
      if ($("#no_ficha").val() == "" || $("#no_factura").val() == "" || $("#total").val() == "" || completo == undefined) {
        swal("Error de Captura", "Verifica la información", "error");
        return false;
      } else {
        var url = 'validar_escarg.php';
        $.ajax({
          type: "POST",
          url: url,
          data: {
            id_proveedor: id_proveedor
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "si") {
              swal({
                  title: "Mercancía sin cargo",
                  text: "¿Existe mercancía sin cargo en esta ficha de entrada?",
                  icon: "warning",
                  buttons: ["Ignorar", "Liberar"],
                  dangerMode: true,
                  closeOnClickOutside: false,
                })
                .then((WillDevolucion) => {
                  if (WillDevolucion) {
                    //Modal escarg
                    $("#modal-articulos").modal("show");
                  } else {
                    finalizar_liberacion();
                  }
                });
            }else{
              finalizar_liberacion();
            }

          }
        });
        return false;
      }
    });
    $("#artc_articulo").keypress(function(e) { //Función que se desencadena al presionar enter
      var url = 'consulta_articulo.php';
      var artc_articulo = $("#artc_articulo").val();
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        if ($("#artc_articulo").val() == "") {

        } else {
          $.ajax({
            type: "POST",
            url: url,
            data: {
              artc_articulo: artc_articulo
            }, // Adjuntar los campos del formulario enviado.
            success: function(respuesta) {
              if (respuesta == "no_existe") {
                $("#artc_cantidad").focus();
              } else {
                $("#artc_descripcion").val(respuesta);
                $("#artc_cantidad").focus();
              }
            }
          });
        }
      }
    });

    $("#btn-agregarArticulo").click(function() {
      var ficha_entrada = $("#no_ficha").val();
      var id_sucursal = $("#id_sucursal").val();
      var id_proveedor = $("#id_proveedor").val();
      var artc_articulo = $("#artc_articulo").val();
      var artc_descripcion = $("#artc_descripcion").val();
      var artc_cantidad = $("#artc_cantidad").val();
      var url = 'agregar_escarg.php';
      if (artc_articulo == "" || artc_cantidad == "") {
        alertify.error("Favor de rellenar todos los datos");
      } else {
        $.ajax({
          type: "POST",
          url: url,
          data: {
            ficha_entrada: ficha_entrada,
            id_sucursal: id_sucursal,
            id_proveedor: id_proveedor,
            artc_articulo: artc_articulo,
            artc_descripcion: artc_descripcion,
            artc_cantidad: artc_cantidad
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            $("#artc_articulo").val('');
            $("#artc_descripcion").val('');
            $("#artc_cantidad").val('');
            $("#artc_articulo").focus();
            alertify.success("Artículo agregado correctamente");
          }
        });
      }
    })
    $("#btn-finalizaEscarg").click(function(){
      $("#modal-articulos").modal("hide");
      finalizar_liberacion();
    })
    function finalizar_liberacion() {
      var completo = $("input[name=completo]:checked").val();
      var id_proveedor = $("#id_proveedor").val();
      var url = "finalizar_liberacion.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: $("#form-datos").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (completo == "no") {
            swal("Orden de Compra", "Datos de recibo capturados completamente", "success")
              .then((value) => {
                window.open("imprimir_folio.php?foc=" + $("#id_orden").val(), "folio", "width=320,height=900,menubar=no,titlebar=no");
                location.href = "index.php";
                //alert("hola");
              });
          } else if (completo == "si") {
            console.log(respuesta);
            window.open("imprimir_folio.php?foc=" + $("#id_orden").val(), "folio", "width=320,height=900,menubar=no,titlebar=no");
            location.href = "carta_faltante.php?id=" + $("#id_orden").val();
          }
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }
  </script>
</body>

</html>