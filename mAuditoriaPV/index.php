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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Auditoría Piso de Venta | Registro</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="codigo">*Código Artículo</label>
                    <input type="text" name="codigo" id="codigo" class="form-control">
                    <input type="hidden" name="articulo" id="articulo">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="comentario">*Comentario</label>
                    <select name="comentario" id="comentario" class="form-control">
                      <option value=""></option>
                      <option value="FALTA SURTIDO">FALTA SURTIDO</option>
                      <option value="FALTA ETIQUETA">FALTA ETIQUETA</option>
                      <option value="REV. TEO. VS FIS.">REV. TEO. VS FIS.</option>
                      <option value="REV. COSTO">REV. COSTO</option>
                      <option value="MERCADEO">MERCADEO</option>
                      <option value="OK">OK</option>
                      <option value="X">X</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="descripcion">*Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="existencia">*Existencia Teórica</label>
                    <input type="text" name="existencia" id="existencia" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="ultima_compra">*Última entrada</label>
                    <input type="text" name="ultima_compra" id="ultima_compra" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="tipo_mov">*Movimiento</label>
                    <input type="text" name="tipo_mov" id="tipo_mov" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="folio_mov">*Folio</label>
                    <input type="text" name="folio_mov" id="folio_mov" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="cantidad_surtida">*Cantidad Comprada</label>
                    <input type="text" name="cantidad_surtida" id="cantidad_surtida" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="proveedor">*Proveedor</label>
                    <input type="text" name="proveedor" id="proveedor" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3 col-xs-6">
                  <div class="form-group">
                    <label for="departamento">*Depto</label>
                    <input type="text" name="departamento" id="departamento" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-3 col-xs-6">
                  <div class="form-group">
                    <label for="familia">*Fam</label>
                    <input type="text" name="familia" id="familia" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                  <div class="form-group">
                    <label for="ult_costo">U.Costo</label>
                    <input type="text" name="ult_costo" id="ult_costo" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                  <div class="form-group">
                    <label for="u_emp">U.Emp</label>
                    <input type="text" name="u_emp" id="u_emp" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                  <div class="form-group">
                    <label for="ventas">Ventas</label>
                    <input type="text" name="ventas" id="ventas" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                  <div class="form-group">
                    <label for="teorico">Teorico</label>
                    <input type="text" name="teorico" id="teorico" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                  <div class="form-group">
                    <label for="faltante">Faltante</label>
                    <input type="text" name="faltante" id="faltante" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                  <div class="form-group">
                    <label for="cajas_faltante">Falt. Cajas</label>
                    <input type="text" name="cajas_faltante" id="cajas_faltante" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                  <div class="form-group">
                    <label for="dias_inv">Dias Inv.</label>
                    <input type="text" name="dias_inv" id="dias_inv" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                  <div class="form-group">
                    <label for="meses_inv">Meses Inv.</label>
                    <input type="text" name="meses_inv" id="meses_inv" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-danger" id="btn-guardar">Guardar registro</button>
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
    $('#comentario').select2({
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity
		})
    $(document).ready(function(e) {
      $("#codigo").focus();
    });
    $("#codigo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_codigo.php"; // El script a dónde se realizará la petición.
        var codigo = $("#codigo").val();
        $("#articulo").val($("#codigo").val());
        $("#codigo").attr("readonly", true);
        $.ajax({
          type: "POST",
          url: url,
          data: {
            codigo: codigo
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "no_existe") {
              swal("Error de captura", "El código que intenta ingresar no existe", "error");
              $("#codigo").val("");
              $("#codigo").focus();
            } else if (respuesta == "registrado") {
              $("#codigo").val("");
              $("#codigo").focus();
            } else {
              $("#codigo").removeAttr("readonly");
              var array = eval(respuesta);
              $("#descripcion").val(array[0]);
              $("#existencia").val(array[1]);
              $("#ultima_compra").val(array[2]);
              $("#tipo_mov").val(array[3]);
              $("#folio_mov").val(array[4]);
              $("#cantidad_surtida").val(array[5]);
              $("#proveedor").val(array[6]);
              $("#departamento").val(array[7]);
              $("#familia").val(array[8]);
              $("#ult_costo").val(array[9]);
              $("#u_emp").val(array[10]);
              $("#ventas").val(array[11]);
              $("#teorico").val(array[12]);
              $("#faltante").val(array[13]);
              $("#cajas_faltante").val(array[14]);
              $("#dias_inv").val(array[15]);
              $("#meses_inv").val(array[16]);
              $("#codigo").val("");
              $("#codigo").focus();

            }
          }
        });
        return false;
      }
    });
    $("#btn-guardar").click(function() {
      var url = "insertar_articulo.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $("#form_datos").serialize(),
        success: function(respuesta) {
          if (respuesta == "ok") {
            swal("El artículo ha sido registrado", {
              position: 'top-end',
              icon: "success",
              closeOnClickOutside: false,
              buttons: false,
              timer: 1500
            });
          } else {
            swal("El artículo ya existe", {
              position: 'top-end',
              icon: "error",
              closeOnClickOutside: false,
              buttons: false,
              timer: 1500
            });
          }
          //alertify.success("Artículo registrado correctamente");
          $("#form_datos")[0].reset();
          $("#codigo").focus();
        },
        error: function(xhr, status) {
          alert("error");
        }
      });
    });
  </script>
</body>

</html>