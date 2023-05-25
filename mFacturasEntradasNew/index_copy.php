<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
$hora = date("h:i:s");
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <script src="funciones.js?v=<?php echo (rand()); ?>"></script>
</head>

<body class="hold-transition skin-red sidebar-mini" onload="javascript:cargar_tabla()">
  <div class="wrapper">
    <header class="main-header">
      <?php include '../header.php'; ?>
    </header>
    <aside class="main-sidebar">
      <?php include 'menuV.php'; ?>
    </aside>
    <div class="content-wrapper">
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Compras | Entradas vs Facturas COPY</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="frmDatosAjustes">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label>*Sucursal</label>
                    <select name="sucursal" class="form-control" id="suc">
                      <option value="" disabled selected>Seleccione...</option>
                      <option value="1">Diaz Ordaz</option>
                      <option value="2">Arboledas</option>
                      <option value="3">Villegas</option>
                      <option value="4">Allende</option>
                      <option value="5">La Petaca</option>
                      <option value="6">Montemorelos</option>
                      <option value="99">CEDIS</option>
                      <option value="203">CEDIS Ropa</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label for="descripcion">*Movimiento</label>
                    <select name="movimiento" class="form-control" id="movimiento">
                      <option disabled selected>Seleccione...</option>
                      <option value="ENTSOC">Entrada sin orden de compra</option>
                      <option value="ENTCOC">Entrada con orden de compra</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label for="bodega">*Folio</label>
                    <input class="form-control" type="text" name="folio" id="folio_mov" onkeyup="if(event.keyCode == 13)execute();">
                  </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="bodega">Proveedor</label>
                    <input type="text" name="proveedor" id="proveedor" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="bodega">Total</label>
                    <input type="text" name="txtTotal" id="txtTotal" class="form-control" readonly>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tipo_operacion">Operación</label>
                    <select name="tipo_operacion" id="tipo_operacion" class="form-control">
                      <option value=""></option>
                      <option value="CARGO">CARGO</option>
                      <option value="ABONO">ABONO</option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box box-footer text-right">
            <a href="#" onclick="registrar_tabla()" class="btn btn-danger">Registrar</a>
            <button onclick="cons()" class="btn btn-danger">Consultar</button>
          </div>
        </div>
        <div class="box box-danger">
					<div class="box-header">
						<h3 class="box-title">Lista de Proveedores</h3>
					</div>
          
					<div class="box-body">
						<div class="row">
						  <div class="col-md-12">
						    <div class="table-responsive">
						      <table id='lista_proveedores' class='table table-striped table-bordered' cellspacing='0' width='100%'>
						        <thead>
						          <tr>
						            <th width="5%">Impuesto</th>
						            <th >Articulo</th>
						            <th >Descripcion</th>
						            <th width="10%">Cantidad</th>
                        <th width="10%">Diferencia</th>
						            <th width="10%">Total</th>
						          </tr>
						        </thead>						        
						      </table>
						    </div>
						  </div>
						</div>
					</div>
        		</div>

        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Información</h3>
          </div>
          <div class="box-body">
            <form id="frmTabla" name="frmTabla">
              <div id="contenedor_tabla"></div>
            </form>
          </div>
        </div>
      </section>
    </div>



    <?php include '../footer2.php'; ?>
    <div class="control-sidebar-bg"></div>
  </div>
  
  <?php include '../footer.php';?>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>


  <!-- <script>CargarBodega();</script>
<script>CargarSistema();</script> -->
  <script>
    function execute() {
      mostrar_tabla();
      consulta_proveedor();
    }
    $('.form_date').datetimepicker({
      language: 'es',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });
    function cons() {
      var folio = $('#folio_mov').val();
      var movimiento = $('#movimiento').val();
      var sucursal = $('#suc').val();
      $.ajax({
        url: "consulta_entrada_existe_copy.php",
        type: "POST",
        dateType: "html",
        data: {
          'folio': folio,
          'movimiento': movimiento,
          'sucursal': sucursal
        },
        success: function(respuesta) {
          if (respuesta == "true") {
            mostrar_tabla();
            consulta_proveedor();
            //registrar_tabla();
            //consultar();
          } else {
            alert("Ya existe un registro con esos datos");
            //mostrar_tabla(); 
            //consulta_proveedor();
          }
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }


    function mostrar_tabla() {
      var folio = $('#folio_mov').val();
      var movimiento = $('#movimiento').val();
      var sucursal = $('#suc').val();
      let data = {
        folio: folio,
        movimiento: movimiento,
        sucursal: sucursal
      };
      var id = $('#folio_mov').val();
      $.ajax({
        url: "tabla_captura_new_copy.php",
        type: "POST",
        dateType: "html",
        data: data,
        success: function(response) {
          $('#contenedor_tabla').html(response);
        },
        error: function(xhr, status) {

        },
      });
    }

    function consulta_proveedor() {
      var folio = $('#folio_mov').val();
      var movimiento = $('#movimiento').val();
      var sucursal = $('#suc').val();
      let data = {
        folio: folio,
        movimiento: movimiento,
        sucursal: sucursal
      };
      $.ajax({
        url: "consulta_proveedor.php",
        type: "POST",
        dateType: "html",
        data: data,
        success: function(response) {
          $('#proveedor').val(response);
        },
        error: function(xhr, status) {

        },
      });
    }

    function registrar_tabla() {
      var folio = $('#folio_mov').val();
      var tipo_mov = $('#movimiento').val();
      var sucursal = $('#suc').val();
      var proveedor = $('#proveedor').val();
      var dif_total = $('#txtTotal').val();
      var tipo_operacion = $("#tipo_operacion").val();
      if (folio == "" || tipo_mov == "" || sucursal == "" || tipo_operacion == "") {
        alert("Rellenar todos los datos");
      } else {
        if (dif_total == 0 || dif_total == "") {
          alert("El total no puede ser 0");
        } else {
          var form_data = new FormData(document.forms.namedItem("frmTabla"));
          form_data.append("folio", folio);
          form_data.append("tipo_mov", tipo_mov);
          form_data.append("sucursal", sucursal);
          form_data.append("proveedor", proveedor);
          form_data.append("diferencia_total", dif_total);
          form_data.append("tipo_operacion", tipo_operacion);
          fetch('registrar.php', {
            method: 'POST',
            body: form_data
          }).then(function(respuesta) {
            return respuesta.text().then(function(text) {
              console.log(text);
              //location.reload();
              window.open("nota_cargo.php?folio=" + folio + "&tipo_mov=" + tipo_mov + "&sucursal=" + sucursal);
            });
          });
        }
      }
    }
  </script>
</body>
</html>