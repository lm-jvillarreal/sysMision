<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>SysAdMisión | Administraci&oacute;n</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="../d_plantilla/bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="../d_plantilla/bower_components/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="../d_plantilla/bower_components/Ionicons/css/ionicons.min.css">
<!-- daterange picker -->
<link rel="stylesheet" href="../d_plantilla/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="../d_plantilla/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="../d_plantilla/plugins/iCheck/all.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="../d_plantilla/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="../d_plantilla/bower_components/select2/dist/css/select2.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="../d_plantilla/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<link rel="stylesheet" href="../d_plantilla/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="../d_plantilla/dist/css/skins/_all-skins.min.css">

<link rel="stylesheet" href="../plugins/alertifyjs/css/alertify.min.css">

<link rel="stylesheet" href="../plugins/alertifyjs/css/themes/default.min.css">

<link rel="stylesheet" href="../plugins/alertifyjs/css/themes/semantic.min.css">

<link rel="stylesheet" href="../plugins/alertifyjs/css/themes/bootstrap.min.css">

<link href="../plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="../d_plantilla/dist/img/logo.png" type='image/png'>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <title>La Misión Supermercados</title>
  <style type="text/css">
    .encabezado{
      height: 2.5em;
      background-color: #B40404;
    }
    .texto-encabezado{
      font-size: 2em;
      margin-top: 0;
      color: #FFFFFF;
    }
    .etiqueta{
      font-size: 1em;
    }
    .tamaño-input class="hidden"{
      font-size: 2em;
    }
    .descripcion{
      font-size: 3em;
    }
    .precio{
      font-size: 5em;
    }
    .oferta{
      font-size: 5em;
      color: #B40404;
    }
    .texto-oferta{
      font-size: 3em;
      color: #B40404;
    }
    hr{
      color: #f00;
      background-color: #f00;
      height: 5px;
      margin-top: 0;
      margin-bottom: 0;
      height: 2px;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row text-center encabezado">
      <h1 class="texto-encabezado">Verificador de Inventario</h1>
      <br>
    </div>
    <div class="pull-right">
      <button type="button" class="btn btn-box-tool" onclick="ocultar();"><i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <br>
  <div class="container">
    <div class="row">
      <form method="POST" id="frmDatos">
      <div class="col-xs-6 col-sm-12 col-md-3 col-lg-3" id="fecha1">
        <div class="form-group">
          <label>*Fecha Inicial</label>
          <input type="date" name="fecha_inicial" class="form-control" id="fecha_inicial">
        </div>
      </div> 
      <div class="col-xs-6 col-sm-12 col-md-3 col-lg-3" id="fecha2">
        <div class="form-group">
          <label for="descripcion">*Fecha Final</label>
            <input type="date" name="fecha_final" id="fecha_final" class="form-control">
        </div>
      </div> 
      <div class="col-xs-6 col-sm-12 col-md-3 col-lg-3">
        <div class="form-group">
          <label for="bodega">*Codigo</label>
          <input class="form-control" type="text" name="codigo" id="codigo">
        </div>
      </div>
      <div class="col-xs-6 col-sm-12 col-md-3 col-lg-3">
        <div class="form-group">
          <label for="bodega">Descripcion</label>
          <input class="form-control" type="text" readonly name="descripcion" id="artc_descripcion">
        </div>
      </div>
      <div class="col-xs-6 col-sm-12 col-md-3 col-lg-3" id="sucursal">
        <div class="form-group">
          <label for="bodega">Sucursal</label>
          <select id="sucursal" name="sucursal" class="form-control select2">
            <option value="1">Diaz Ordaz</option>
            <option value="2">Arboledas</option>
            <option value="3">Villegas</option>
            <option value="4">Allende</option>
            <option value="5">La Petaca</option>
            <option value="99">CEDIS</option>
          </select>
        </div>
      </div>
      </form>
      <div class="col-xs-6 col-sm-12 col-md-3 col-lg-3">
        <br>
          <button id="btnConsultar"  class="btn btn-danger">
            Consultar
          </button>
          <button id="cargando"  class="btn btn-danger" style="display: none;">
            <div class="overlay" id="buscar">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </button>
      </div>
    </div>
    <br>
    <div class="container">
      <div class="row">
        <div class="col-xs-6">
          <label>Inventario Inicial: </label>
          <input class="hidden" type="text" id="inv_inicial" class="form-control">
        </div>
        <div class="col-xs-6">
          <label id="v_inv_inicial"></label>
        </div>
      </div>
      <hr>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label id="c_comprada">Cantidad Comprada: </label>
          <input class="hidden" type="text" class="form-control" id="cantidad_comprada">
        </div>
        <div class="col-xs-6">
          <label id="v_cantidad_comprada"></label>
        </div>
      </div> 
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label id="e_trans">Entradas x Transf: </label>
          <input class="hidden" type="text" class="form-control" id="entradas_transf">
        </div>
        <div class="col-xs-6">
          <label id="v_entradas_transf"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label id="ae_trans">Ajuste entradas x transf: </label>
          <input class="hidden" type="text" id="atrans" class="form-control">
        </div>
        <div class="col-xs-6">
          <label id="v_atrans"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label id="altas_inventario">Altas de inventario: </label>
          <input class="hidden" type="text" id="altas_inventario" class="form-control">
        </div>
        <div class="col-xs-6">
          <label id="v_altas_inventario"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label>Devol. de venta: </label>
          <input class="hidden" type="text" class="form-control" id="devolucion_venta">
        </div>
        <div class="col-xs-6">
          <label id="v_devolucion_venta"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label id="lbl_ajustes_f">Ajustes Forzosos: </label>
          <input class="hidden" type="text" id="ajustes_forzosos" class="form-control">
        </div>
        <div class="col-xs-6">
          <label id="v_ajustes_forzosos"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label>Total de entradas: </label>
          <input class="hidden" type="text" class="form-control" id="total_entradas">
        </div>
        <div class="col-xs-6">
          <label id="v_total_entradas"></label>
        </div>
      </div>
      <!----------------->
      <hr>
      <div class="row">
        <div class="col-xs-6">
          <label>Cantidad vendida: </label>
          <input class="hidden" type="text" class="form-control" id="cantidad_vendida">
        </div>
        <div class="col-xs-6">
          <label id="v_cantidad_vendida"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label id="salidas_x_transf">Salidas x Transf: </label>
          <input class="hidden" type="text" class="form-control" id="salidas_transf">
        </div>
        <div class="col-xs-6">
          <label id="v_salidas_transf"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label id="astrans">Ajuste salidas x transf: </label>
          <input class="hidden" type="text" class="form-control" id="aetrans">
        </div>
        <div class="col-xs-6">
          <label id="v_aetrans"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label id="b_i">Bajas de inventario: </label>
          <input class="hidden" type="text" id="bajas_inventario" class="form-control">
        </div>
        <div class="col-xs-6">
          <label id="v_bajas_inventario"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label id="b_i">Pendiente SIROTA: </label>
          <!-- <input class="hidden" type="text" id="bajas_inventario" class="form-control"> -->
        </div>
        <div class="col-xs-6">
          <label id="sirota"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label>Devol. de compra: </label>
          <input class="hidden" type="text" id="devolucion_compra" class="form-control">
        </div>
        <div class="col-xs-6">
          <label id="v_devolucion_compra"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label id="u_mermas">Unidades Mermadas: </label>
          <input class="hidden" type="text" class="form-control" id="mermas">
        </div>
        <div class="col-xs-6">
          <label id="v_mermas"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label>Salidas Restaurante: </label>
          <input class="hidden" type="text" class="form-control" id="salida_restaurante">
        </div>
        <div class="col-xs-6">
          <label id="v_salida_restaurante"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label>Total de salidas: </label>
          <input class="hidden" type="text" id="total_salidas" class="form-control">
        </div>
        <div class="col-xs-6">
          <label id="v_total_salidas"></label>
        </div>
      </div>
      <hr>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label>Total Teorico Inventarios: </label>
          <input class="hidden" type="text" class="form-control" id="existencia">
        </div>
        <div class="col-xs-6">
          <label id="v_existencia"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label>Pendientes de afectar: </label>
          <input type="text" id="pendientes_afectar" class="form-control hidden">
        </div>
        <div class="col-xs-6">
          <label id="v_pendientes_afectar"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label>Ventas en Proceso: </label>
          <input class="hidden" type="text" class="form-control" id="venta_proceso">
        </div>
        <div class="col-xs-6">
          <label id="v_venta_proceso"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label>Teorico Final: </label>
          <input class="hidden" type="text" class="form-control" id="teorico_final" >
        </div>
        <div class="col-xs-6">
          <label id="v_teorico_final"></label>
        </div>
      </div>
      <hr>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label>Teorico Calculado: </label>
          <input class="hidden" type="text" class="form-control" id="teorico_calc">
        </div>
        <div class="col-xs-6">
          <label id="v_teorico_calc"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label>Inventario Fisico:</label>
          <input type="text" id="inventario_fisico" class="form-control hidden">
        </div>
        <div class="col-xs-6">
          <label id="v_inventario_fisico"></label>
        </div>
      </div>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label>Diferencia Fis vs Teo(CALC): </label>
          <input class="hidden" type="text" id="diferencia" class="form-control">
        </div>
        <div class="col-xs-6">
          <label id="v_diferencia"></label>
        </div>
      </div>
      <hr>
      <!----------------->
      <div class="row">
        <div class="col-xs-6">
          <label id="lbl_separado">Separado: </label>
          <input class="hidden" type="text" id="separado" class="form-control">
        </div>
        <div class="col-xs-6">
          <label id="v_separado"></label>
        </div>
      </div>
    </div>
  </div>
  <br>
  <script src="assets/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script>
    $('#codigo').change(function() {
    var codigo = $('#codigo').val();
    $.ajax({
      data: {
          'codigo': codigo
      }, //datos que se envian a traves de ajax
      url: 'consulta_codigo.php', //archivo que recibe la peticion
      type: 'POST', //método de envio
      dateType: 'html',
      beforeSend: function() {},
      success: function(response) {
        if (response == "") {
            response = "N/A";
        } else {
            response = response;
        }
        $('#artc_descripcion').val(response);
      }
    });
    });   
   $('#btnConsultar').click(function() {
    $.ajax({
        data: $('#frmDatos').serialize(), //datos que se envian a traves de ajax
        url: 'datos_sucursal.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        beforeSend: function() {
            $('#cargando').show();
            $('#btnConsultar').hide();
            //$('#cargando').show();
        },
        success: function(response) {
            // $('#formulario').show();
            $('#btnConsultar').show();
            $('#cargando').hide();
            ocultar();
            var array = eval(response);
            $('#cantidad_comprada').val(array[0]);
            $('#v_cantidad_comprada').html(array[0]);

            $('#entradas_transf').val(array[1]);
            $('#v_entradas_transf').html(array[1]);

            $('#altas_inventario').val(array[2]);
            $('#v_altas_inventario').html(array[2]);

            $('#devolucion_venta').val(array[3]);
            $('#v_devolucion_venta').html(array[3]);

            $('#ajustes_forzosos').val(array[4]);
            $('#v_ajustes_forzosos').html(array[4]);

            $('#cantidad_vendida').val(array[5]);
            $('#v_cantidad_vendida').html(array[5]);

            $('#salidas_transf').val(array[6]);
            $('#v_salidas_transf').html(array[6]);

            $('#bajas_inventario').val(array[7]);
            $('#v_bajas_inventario').html(array[7]);

            $('#devolucion_compra').val(array[8]);
            $('#v_devolucion_compra').html(array[8]);

            $('#existencia').val(array[9]);
            $('#v_existencia').html(array[9]);

            $('#inventario_fisico').val(array[10]);
            $('#v_inventario_fisico').html(array[10]);

            $('#venta_proceso').val(array[11]);
            $('#v_venta_proceso').html(array[11]);

            $('#pendientes_afectar').val(array[12]);
            $('#v_pendientes_afectar').html(array[12]);

            $('#atrans').val(array[14]);
            $('#v_atrans').html(array[14]);

            $('#aetrans').val(array[15]);
            $('#v_aetrans').html(array[15]);

            $('#mermas').val(array[13]);
            $('#v_mermas').html(array[13]);

            $('#inv_inicial').val(array[16]);
            $('#v_inv_inicial').html(array[16]);

            $('#separado').val(array[17]);
            $('#v_separado').html(array[17]);

            $('#salida_restaurante').val(array[18]);
            $('#v_salida_restaurante').html(array[18]);
            $('#sirota').html(array[19]);
            suma_entrada();
            suma_salidas();
            calcular_teorico();
            existencia_real();
            diferencia();
            //suma_entrada();
            //suma_salidas();
            existencia_real();
        }
    });
    });
    function suma_entrada() {
      var comprada         = $('#cantidad_comprada').val();
      var entradas_transf  = $('#entradas_transf').val();
      var altas_inventario = $('#altas_inventario').val();
      var devolucion_venta = $('#devolucion_venta').val();
      
      var total = parseFloat(comprada) + parseFloat(entradas_transf) + parseFloat(altas_inventario) + parseFloat(devolucion_venta);
      $('#total_entradas').val(total);
      $('#v_total_entradas').html(total);
    }

    function suma_salidas() {
      var venta             = $('#cantidad_vendida').val();
      var mermas            = $('#mermas').val();
      var salida_transf     = $('#salidas_transf').val();
      var bajas_inv         = $('#bajas_inventario').val();
      var devolucion_compra = $('#devolucion_compra').val();
      var salida_transf     = $('#salida_restaurante').val();
      var total = parseFloat(venta) + parseFloat(salida_transf) + parseFloat(bajas_inv) + parseFloat(devolucion_compra) + parseFloat(salida_transf)  + parseFloat(mermas);
      $('#total_salidas').val(total);  
      $('#v_total_salidas').html(total);  
    }

    function diferencia() {
      var teorico_calc = $('#teorico_calc').val();
      var inv_fisico = $('#inventario_fisico').val();
      var diferencia = parseFloat(inv_fisico) - parseFloat(teorico_calc);
      var fis = Math.abs(diferencia);
      $('#diferencia').val(diferencia); 
      $('#v_diferencia').html(diferencia); 
    }

    function blanco() {
      $('#formulario').hide();
      $('#cargando').hide();
      $('#cargando_barra').hide();
    }

    function existencia_real() {
      var teorico    = $('#existencia').val();
      var pendientes = $('#pendientes_afectar').val();
      var v_proceso  = $('#venta_proceso').val();
      var teorico_final = parseFloat(teorico) - parseFloat(pendientes) - parseFloat(v_proceso);
      $('#teorico_final').val(teorico_final);
      $('#v_teorico_final').html(teorico_final);
    }

    function calcular_teorico() {
      var inicial  = $('#inv_inicial').val();
      var entradas = $('#total_entradas').val();
      var salidas  = $('#total_salidas').val();
      var teorico_calc = (parseFloat(inicial) + parseFloat(entradas)) - parseFloat(salidas);
      $('#teorico_calc').val(teorico_calc);
      $('#v_teorico_calc').html(teorico_calc);
    }
    function ocultar(){
      if ($('#fecha1').hasClass('hidden')){
        $('#fecha1').removeClass('hidden');  
      }
      else{
        $('#fecha1').addClass('hidden');
      }
      if ($('#fecha2').hasClass('hidden')){
        $('#fecha2').removeClass('hidden');  
      }
      else{
        $('#fecha2').addClass('hidden');
      }
      if ($('#sucursal').hasClass('hidden')){
        $('#sucursal').removeClass('hidden');  
      }
      else{
        $('#sucursal').addClass('hidden');
      }
      if ($('#btnConsultar').hasClass('hidden')){
        $('#btnConsultar').removeClass('hidden');  
      }
      else{
        $('#btnConsultar').addClass('hidden');
      }
    }
  </script>
</body>
</html>
