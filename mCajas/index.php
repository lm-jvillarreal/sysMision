<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
$hora = date("h:i:s");
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
            <h3 class="box-title">Recibo | Cajas de articulos</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form-datos">
              <div class="row">
                <div class="col-md-2">
                  <label>Codigo caja</label>
                  <input type="text" name="" id="codigo_caja" onkeyup="if (event.keyCode == 13) crear_caja($(this).val())" class="form-control">
                  <input type="hidden" name="" id="id_caja">
                </div>
                <div class="col-md-3">
                  <label>Descripcion Caja</label>
                  <input type="text" name="" id="descripcion" readonly value="caja" class="form-control">
                </div>
                <div class="col-md-2">
                  <label>Codigo Articulo</label>
                  <input type="text" name="" id="codigo" onkeyup="if (event.keyCode == 13) ingresar_cantidad($(this).val())" class="form-control">
                </div>
                <div class="col-md-3">
                  <label>Descripcion Articulo</label>
                  <input type="text" name="" readonly id="descripcion_articulo" class="form-control">
                </div>
                <div class="col-md-2">
                  <label>Cantidad</label>
                  <input type="text" name="" id="cantidad" class="form-control" onkeyup="if(event.keyCode == 13) agregar_articulo($('#codigo').val(), $('#id_caja').val(), $(this).val(), $('#descripcion_articulo').val())">
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <a href="" onclick="javascript:save()" class="btn btn-danger">Limpiar</a>
            <a href="rpt_analisis.php" class="btn btn-danger">Reporte</a>
            <a href="#" onclick="mostrar_lista()" class="btn btn-danger">Lista</a>
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
                  <div id="contenedor_tabla"></div>
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
    function ingresar_cantidad(codigo) {

      $.ajax({
        data: {
          'codigo': codigo
        }, //datos que se envian a traves de ajax
        url: 'consulta_codigo.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
          $('#descripcion_articulo').val(response);
          var desc_caja = $('#descripcion').val() + "-" + codigo;
          $('#descripcion').val(desc_caja);
          $('#cantidad').focus();

        }
      });
    }

    function crear_caja(codigo, descripcion) {
      $.ajax({
        data: {
          'codigo': codigo,
          'descripcion': descripcion
        }, //datos que se envian a traves de ajax
        url: 'crear_caja.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
          if (response == "false") {
            alert("Ya existe una caja con ese codigo");
            blanco();
          } else {
            $('#id_caja').val(response);
            $('#codigo').focus();
          }

        }
      });
    }

    function modificar_descripcion(descripcion, codigo) {
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

    function save() {
      location.reload();
    }


    function mostrar_lista() {
      $('#descripcion').removeAttr('readonly');
      $('#contenedor_tabla').load('tabla_cajas.php');
    }

    function borrar_caja(id_caja) {
      $.ajax({
        data: {
          'id_caja': id_caja

        }, //datos que se envian a traves de ajax
        url: 'borrar_caja.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
          alertify.success("Registro Borrado");
          mostrar_lista();
        }
      });
    }

    function editar_caja(id_caja) {
      $.ajax({
        data: {
          'id_caja': id_caja
        }, //datos que se envian a traves de ajax
        url: 'datos_caja.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
          var array = eval(response);
          $('#codigo_caja').attr('readonly', true);
          $('#codigo_caja').val(array[1]);
          $('#descripcion').val(array[2]);
          $('#id_caja').val(id_caja);
          recargar_tabla(id_caja);
        }
      });
    }
  </script>
</body>

</html>