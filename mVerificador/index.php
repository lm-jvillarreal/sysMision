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
            <h3 class="box-title">Compras | Verificador de inventarios</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="frmDatos">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label>*Fecha Inicial</label>
                    <input type="date" name="fecha_inicial" class="form-control" id="fecha_inicial">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="descripcion">*Fecha Final</label>
                    <input type="date" name="fecha_final" id="fecha_final" class="form-control">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="bodega">*Codigo</label>
                    <input class="form-control" type="text" name="codigo" id="codigo">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="bodega">Descripcion</label>
                    <input class="form-control" type="text" readonly name="descripcion" id="artc_descripcion">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="bodega">Sucursal</label>
                    <select id="sucursal" name="sucursal" class="form-control select">
                      <option value="1">Diaz Ordaz</option>
                      <option value="2">Arboledas</option>
                      <option value="3">Villegas</option>
                      <option value="4">Allende</option>
                      <option value="5">La Petaca</option>
                      <option value="99">CEDIS</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-4" style="display: none" id="barra">
                  <img src="barra.gif" height="100" width="100">
                </div>
              </div>
              <div class="row">

              </div>
            </form>
          </div>
          <div class="box box-footer text-right">
            <button id="btnConsultar" class="btn btn-danger">Consultar</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Información</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <label>Inventario Inicial</label>
                <input type="text" id="inv_inicial" class="form-control" onchange="javascript:calcular_teorico()">
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <label id="c_comprada" style="color: red">Cantidad Comprada</label>
                <input type="text" class="form-control" id="cantidad_comprada">
              </div>
              <div class="col-md-3">
                <label>Cantidad vendida</label>
                <input type="text" class="form-control" id="cantidad_vendida">
              </div>
              <div class="col-md-3">
                <label>Total teorico inventarios</label>
                <input type="text" class="form-control" id="existencia">
              </div>
              <div class="col-md-3">
                <label>Teorico Calculado</label>
                <input type="text" class="form-control" id="teorico_calc">
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <label id="e_trans" style="color: red">Entradas x Transf</label>
                <input type="text" class="form-control" id="entradas_transf">
              </div>
              <div class="col-md-3">
                <label id="salidas_x_transf" style="color: red">Salidas x Transf</label>
                <input type="text" class="form-control" id="salidas_transf">
              </div>
              <div class="col-md-3">
                <label>Pendientes de afectar</label>
                <input type="text" class="form-control" id="pendientes_afectar">
              </div>
              <div class="col-md-3">
                <label ondblclick="javascript:cargar_tabla_captura()">Inventario Fisico</label>
                <input type="text" id="inventario_fisico" class="form-control">
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <label id="ae_trans" style="color: red">Ajuste entradas x transf</label>
                <input type="text" id="atrans" class="form-control">
              </div>
              <div class="col-md-3">
                <label id="astrans" style="color: red">Ajuste salidas x transf</label>
                <input type="text" class="form-control" id="aetrans">
              </div>
              <div class="col-md-3">
                <label>Ventas en Proceso</label>
                <input type="text" class="form-control" id="venta_proceso">
              </div>
              <div class="col-md-3">
                <label>Diferencia Fis vs Teo(CALC)</label>
                <input type="text" id="diferencia" class="form-control">
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <label id="lbl_altas_inventario" style="color: red">Altas de inventario</label>
                <input type="text" id="altas_inventario" class="form-control">
              </div>
              <div class="col-md-3">
                <label id="b_i" style="color: red">Bajas de inventario</label>
                <input type="text" id="bajas_inventario" class="form-control">
              </div>
              <div class="col-md-3">
                <label>Pendiente SIROTA</label>
                <input type="text" class="form-control" id="sirota">
              </div>
              <!-- <div class="col-md-3">
              <label>Teorico Final</label>
              <input type="text" class="form-control" id="teorico_final" >
            </div> -->
            </div>
            <div class="row">
              <div class="col-md-3">
                <label>Devol. de venta</label>
                <input type="text" class="form-control" id="devolucion_venta">
              </div>
              <div class="col-md-3">
                <label>Devol. de compra</label>
                <input type="text" id="devolucion_compra" class="form-control">
              </div>
              <div class="col-md-3">
                <label>Teorico Final</label>
                <input type="text" class="form-control" id="teorico_final">
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <label id="lbl_ajustes_f" style="color: red">Ajustes Forzosos</label>
                <input type="text" id="ajustes_forzosos" class="form-control">
              </div>
              <div class="col-md-3">
                <label id="u_mermas" style="color: red">Unidades Mermadas</label>
                <input type="text" class="form-control" id="mermas">
              </div>
              <div class="col-md-3">
                <label>Salidas Restaurante</label>
                <input type="text" class="form-control" id="salida_restaurante">
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <label>Total de entradas</label>
                <input type="text" class="form-control" id="total_entradas">
              </div>
              <div class="col-md-3">
                <label>Total de salidas</label>
                <input type="text" id="total_salidas" class="form-control">
              </div>
              <div class="col-md-3">
                <label id="lbl_separado" style="color: red">Separado</label>
                <input type="text" id="separado" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-title">
            <h3>Datos Extras</h3>
          </div>
          <div class="box-body" id="div_compras" style="display: none">
            <div class="table-responsive">
              <table id="lista_gastos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>S</th>
                    <th>Orden</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Costo</th>
                    <th>Importe</th>
                    <th>Proveedor</th>
                    <th>Usuario</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>S</th>
                    <th>Orden</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Costo</th>
                    <th>Importe</th>
                    <th>Proveedor</th>
                    <th>Usuario</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="box-body" id="div_e_transf" style="display: none">
            <div class="table-responsive">
              <table id="lista_etrans" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Consec.</th>
                    <th>Almacén Destino</th>
                    <th>Folio Entrada</th>
                    <th>Almacén Salida</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <div class="box-body" id="div_mermas" style="display: none">
            <div class="table-responsive">
              <table id="lista_mermas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Sucursal Afectada</th>
                    <th>Movimiento</th>
                    <th>Folio</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Sucursal Afectada</th>
                    <th>Movimiento</th>
                    <th>Folio</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="box-body" id="div_aetrans" style="display: none">
            <div class="table-responsive">
              <table id="lista_aetrans" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Sucursal Afectada</th>
                    <th>Tipo Mov</th>
                    <th>Folio</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Sucursal Afectada</th>
                    <th>Tipo Mov</th>
                    <th>Folio</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="box-body" id="div_altas_inv" style="display: none">
            <div class="table-responsive">
              <table id="lista_ainventario" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>S</th>
                    <th>Folio Mov</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Usuario</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>S</th>
                    <th>Folio Mov</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Usuario</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="box-body" id="div_salidas_transf" style="display: none">
            <div class="table-responsive">
              <table id="lista_salidas_x_transf" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Consec.</th>
                    <th>Almacén Salida</th>
                    <th>Folio Salida</th>
                    <th>Almacén Destino</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <div class="box-body" id="div_astrans" style="display: none">
            <div class="table-responsive">
              <table id="lista_astrans" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Sucursal</th>
                    <th>Tipo Mov</th>
                    <th>Folio</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Sucursal</th>
                    <th>Tipo Mov</th>
                    <th>Folio</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="box-body" id="div_bi" style="display: none">
            <div class="table-responsive">
              <table id="lista_bi" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Sucursal</th>
                    <th>Folio Mov</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Usuario</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Sucursal</th>
                    <th>Folio Mov</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Usuario</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="box-body" id="div_separado" style="display: none">
            <div class="table-responsive">
              <table id="lista_separado" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Folio</th>
                    <th># cliente</th>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Folio</th>
                    <th># cliente</th>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="box-body" id="div_ajustes" style="display: none">
            <div class="table-responsive">
              <table id="lista_ajustes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Sucursal</th>
                    <th>Tipo Mov</th>
                    <th>Folio</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Sucursal</th>
                    <th>Tipo Mov</th>
                    <th>Folio</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="box-body" id="div_captura" style="display: none">
            <div class="table-responsive">
              <table id="lista_captura" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Area</th>
                    <th>Zona</th>
                    <th>Mueble</th>
                    <th>Cara</th>
                    <th>Estante</th>
                    <th>Consecutivo</th>
                    <th>Cantidad</th>
                    <th>Usuario</th>
                    <th>Tipo</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Area</th>
                    <th>Zona</th>
                    <th>Mueble</th>
                    <th>Cara</th>
                    <th>Estante</th>
                    <th>Consecutivo</th>
                    <th>Cantidad</th>
                    <th>Usuario</th>
                    <th>Tipo</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="box-footer"></div>
        </div>
      </section>
    </div>
    <?php include '../footer2.php'; ?>
    <div class="control-sidebar-bg"></div>
  </div>
  <?php include '../footer.php'; ?>
  <!-- <script src="funciones.js"></script> -->
  <!-- <script>CargarBodega();</script>
<script>CargarSistema();</script> -->
  <script>
    function estilo_tablas() {
      $('#lista').DataTable({
        'paging': false,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': true,
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        }
      })
    }
    $.validator.setDefaults({
      submitHandler: function() {
        var url = "insertar.php";
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_materiales").serialize(),
          success: function(respuesta) {
            if (respuesta == 1) {
              alertify.error("Algunos Campos Estan Vacios.", 2);
              document.getElementById("nombre").focus();
            } else if (respuesta == 2) {
              alertify.success("Se Regitro Correctamente.", 2);
              $(":text").val('');
              document.getElementById("existencia").value = "";
              // cargar_tabla();
              // CargarBodega();
              // CargarSistema();
              document.getElementById("nombre").focus();
            } else {
              alertify.error("Algo salio Mal.", 2);
              $(":text").val('');
              // cargar_tabla();
            }
          }
        });
        return false;
      }
    });
    $(document).ready(function() {
      $("#form_materiales").validate({
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
        errorPlacement: function(error, element) {
          error.addClass("help-block");
          if (element.prop("type") === "checkbox") {
            error.insertAfter(element.parent("label"));
          } else {
            error.insertAfter(element);
          }
        },
        highlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-2").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-8").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-10").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-12").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-2").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-8").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-10").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-12").addClass("has-success").removeClass("has-error");
        }
      });
    });
  </script>
  <script>
    $(function() {
      $('.select').select2({
        placeholder: "Seleccione una opcion"
      });
    });
  </script>
  <script type="text/javascript">
    $('.form_datetime').datetimepicker({
      //language:  'fr',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
      showMeridian: 1
    });
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
    $('.form_time').datetimepicker({
      language: 'fr',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 1,
      minView: 0,
      maxView: 1,
      forceParse: 0
    });
  </script>

  <script type="text/javascript">
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
          $('#barra').removeAttr('style');
          //$('#cargando').show();
        },
        success: function(response) {
          $('#formulario').show();
          $('#barra').hide();
          var array = eval(response);
          $('#cantidad_comprada').val(array[0]);
          $('#entradas_transf').val(array[1]);
          $('#altas_inventario').val(array[2]);
          $('#devolucion_venta').val(array[3]);
          $('#ajustes_forzosos').val(array[4]);
          $('#cantidad_vendida').val(array[5]-array[3]);
          $('#salidas_transf').val(array[6]);
          $('#bajas_inventario').val(array[7]);
          $('#devolucion_compra').val(array[8]);
          $('#existencia').val(array[9]);
          $('#inventario_fisico').val(array[10]);
          $('#venta_proceso').val(array[11]);
          $('#pendientes_afectar').val(array[12]);
          $('#atrans').val(array[14]);
          $('#aetrans').val(array[15]);
          $('#mermas').val(array[13]);
          $('#inv_inicial').val(array[16]);
          $('#separado').val(array[17]);
          $('#salida_restaurante').val(array[18]);
          $('#sirota').val(array[19]);
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
      var comprada = $('#cantidad_comprada').val();
      var entradas_transf = $('#entradas_transf').val();
      var altas_inventario = $('#altas_inventario').val();
      //var devolucion_venta = $('#devolucion_venta').val();

      //var total = parseFloat(comprada) + parseFloat(entradas_transf) + parseFloat(altas_inventario) + parseFloat(devolucion_venta);
      var total = parseFloat(comprada) + parseFloat(entradas_transf) + parseFloat(altas_inventario);
      $('#total_entradas').val(total);
    }

    function suma_salidas() {
      var venta = $('#cantidad_vendida').val();
      var mermas = $('#mermas').val();
      var salida_transf = $('#salidas_transf').val();
      var bajas_inv = $('#bajas_inventario').val();
      var devolucion_compra = $('#devolucion_compra').val();
      var salida_transf_res = $('#salida_restaurante').val();

      var total = parseFloat(venta) + parseFloat(salida_transf) + parseFloat(bajas_inv) + parseFloat(devolucion_compra) + parseFloat(salida_transf_res) + parseFloat(mermas);
      var grupo = {
        venta: venta,
        mermas: mermas,
        salida_transf: salida_transf,
        bajas_inv: bajas_inv,
        devolucion_compra: devolucion_compra,
        salida_transf: salida_transf,
        total: total
      };
      console.log(grupo);
      $('#total_salidas').val(total);

    }

    function diferencia() {
      var teorico_calc = $('#teorico_calc').val();
      var inv_fisico = $('#inventario_fisico').val();
      var diferencia = parseFloat(inv_fisico) - parseFloat(teorico_calc);
      var fis = Math.abs(diferencia);
      $('#diferencia').val(diferencia);
    }

    function blanco() {
      $('#formulario').hide();
      $('#cargando').hide();
      $('#cargando_barra').hide();
    }

    function existencia_real() {
      var teorico = $('#existencia').val();
      var pendientes = $('#pendientes_afectar').val();
      var v_proceso = $('#venta_proceso').val();
      var sirota = $('#sirota').val();
      var teorico_final = parseFloat(teorico) - (parseFloat(pendientes) + parseFloat(v_proceso) + parseFloat(sirota));
      $('#teorico_final').val(teorico_final);
    }

    function calcular_teorico() {
      var inicial = $('#inv_inicial').val();
      var entradas = $('#total_entradas').val();
      var salidas = $('#total_salidas').val();
      if (inicial == 0) {
        var teorico_calc = (parseFloat(inicial) + parseFloat(entradas)) - parseFloat(salidas);
      } else {
        var teorico_calc = (parseFloat(inicial) + parseFloat(entradas)) - parseFloat(salidas);
      }

      $('#teorico_calc').val(teorico_calc);
    }
  </script>

  <script type="text/javascript">
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity,
      ajax: {
        url: "consulta_sucursal.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term // search term
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      }
    })
    $("#sucursal option:first").attr('selected', 'selected');
  </script>
  <script type="text/javascript">
    function cargar_tabla() {
      var codigo = $('#codigo').val();
      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();
      var sucursal = $('#sucursal').val();
      $('#lista_gastos').dataTable().fnDestroy();
      $('#lista_gastos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_compras.php",
          "dataSrc": "",
          "data": {
            "fecha_inicial": fecha_inicial,
            "fecha_final": fecha_final,
            "sucursal": sucursal,
            "codigo": codigo
          },
        },
        "columns": [{
            "data": "s"
          },
          {
            "data": "orden"
          },
          {
            "data": "tipo"
          },
          {
            "data": "fecha"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "costo"
          },
          {
            "data": "importe"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "usuario"
          }
        ]
      });
    }

    function cargar_tabla_e_trans() {
      var codigo = $('#codigo').val();
      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();
      var sucursal = $('#sucursal').val();
      $('#lista_etrans').dataTable().fnDestroy();
      $('#lista_etrans').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_e_transf.php",
          "dataSrc": "",
          "data": {
            "fecha_inicial": fecha_inicial,
            "fecha_final": fecha_final,
            "sucursal": sucursal,
            "codigo": codigo
          },
        },
        "columns": [{
            "data": "consecutivo"
          },
          {
            "data": "almacen"
          },
          {
            "data": "folio_salida"
          },
          {
            "data": "destino"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "fecha"
          }
        ]
      });
    }

    function cargar_tabla_captura() {
      $('#div_captura').show();
      var codigo = $('#codigo').val();
      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();
      var sucursal = $('#sucursal').val();
      $('#lista_captura').dataTable().fnDestroy();
      $('#lista_captura').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_captura.php",
          "dataSrc": "",
          "data": {
            "fecha_inicial": fecha_inicial,
            "fecha_final": fecha_final,
            "sucursal": sucursal,
            "codigo": codigo
          },
        },
        "columns": [{
            "data": "area"
          },
          {
            "data": "zona"
          },
          {
            "data": "mueble"
          },
          {
            "data": "cara"
          },
          {
            "data": "estante"
          },
          {
            "data": "consecutivo"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "usuario"
          },
          {
            "data": "tipo"
          }


        ]
      });
    }

    function cargar_mermas() {
      var codigo = $('#codigo').val();
      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();
      var sucursal = $('#sucursal').val();
      $('#lista_mermas').dataTable().fnDestroy();
      $('#lista_mermas').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_mermas.php",
          "dataSrc": "",
          "data": {
            "fecha_inicial": fecha_inicial,
            "fecha_final": fecha_final,
            "sucursal": sucursal,
            "codigo": codigo
          },
        },
        "columns": [{
            "data": "sucursal"
          },
          {
            "data": "movimiento"
          },
          {
            "data": "folio"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "fecha"
          }
        ]
      });
    }

    function cargar_aetrans() {
      var codigo = $('#codigo').val();
      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();
      var sucursal = $('#sucursal').val();
      $('#lista_aetrans').dataTable().fnDestroy();
      $('#lista_aetrans').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_aetrans.php",
          "dataSrc": "",
          "data": {
            "fecha_inicial": fecha_inicial,
            "fecha_final": fecha_final,
            "sucursal": sucursal,
            "codigo": codigo
          },
        },
        "columns": [{
            "data": "s"
          },
          {
            "data": "tipo"
          },
          {
            "data": "folio"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "fecha"
          }
        ]
      });
    }

    function cargar_ainventario() {
      var codigo = $('#codigo').val();
      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();
      var sucursal = $('#sucursal').val();
      $('#lista_ainventario').dataTable().fnDestroy();
      $('#lista_ainventario').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_ainventario.php",
          "dataSrc": "",
          "data": {
            "fecha_inicial": fecha_inicial,
            "fecha_final": fecha_final,
            "sucursal": sucursal,
            "codigo": codigo
          },
        },
        "columns": [{
            "data": "s"
          },
          {
            "data": "folio"
          },
          {
            "data": "tipo"
          },
          {
            "data": "fecha"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "cantidad"
          }
        ]
      });
    }

    function cargar_salidas_x_transf() {
      var codigo = $('#codigo').val();
      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();
      var sucursal = $('#sucursal').val();
      $('#lista_salidas_x_transf').dataTable().fnDestroy();
      $('#lista_salidas_x_transf').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_sal_transf.php",
          "dataSrc": "",
          "data": {
            "fecha_inicial": fecha_inicial,
            "fecha_final": fecha_final,
            "sucursal": sucursal,
            "codigo": codigo
          },
        },
        "columns": [{
            "data": "consecutivo"
          },
          {
            "data": "almacen"
          },
          {
            "data": "folio_salida"
          },
          {
            "data": "destino"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "fecha"
          }
        ]
      });
    }

    function cargar_astrans() {
      var codigo = $('#codigo').val();
      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();
      var sucursal = $('#sucursal').val();
      $('#lista_astrans').dataTable().fnDestroy();
      $('#lista_astrans').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_astrans.php",
          "dataSrc": "",
          "data": {
            "fecha_inicial": fecha_inicial,
            "fecha_final": fecha_final,
            "sucursal": sucursal,
            "codigo": codigo
          },
        },
        "columns": [{
            "data": "s"
          },
          {
            "data": "tipo_mov"
          },
          {
            "data": "folio"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "fecha"
          }

        ]
      });
    }

    function cargar_bi() {
      var codigo = $('#codigo').val();
      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();
      var sucursal = $('#sucursal').val();
      $('#lista_bi').dataTable().fnDestroy();
      $('#lista_bi').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_bi.php",
          "dataSrc": "",
          "data": {
            "fecha_inicial": fecha_inicial,
            "fecha_final": fecha_final,
            "sucursal": sucursal,
            "codigo": codigo
          },
        },
        "columns": [{
            "data": "s"
          },
          {
            "data": "folio"
          },
          {
            "data": "tipo"
          },
          {
            "data": "fecha"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "usuario"
          }

        ]
      });
    }

    function cargar_separado() {
      var codigo = $('#codigo').val();
      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();
      var sucursal = $('#sucursal').val();
      $('#lista_separado').dataTable().fnDestroy();
      $('#lista_separado').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_separado.php",
          "dataSrc": "",
          "data": {
            "fecha_inicial": fecha_inicial,
            "fecha_final": fecha_final,
            "sucursal": sucursal,
            "codigo": codigo
          },
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "cliente"
          },
          {
            "data": "nombre"
          },
          {
            "data": "fecha"
          },
          {
            "data": "cantidad"
          }
        ]
      });
    }

    function cargar_ajustes() {
      var codigo = $('#codigo').val();
      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();
      var sucursal = $('#sucursal').val();
      $('#lista_ajustes').dataTable().fnDestroy();
      $('#lista_ajustes').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_ajustes_neg.php",
          "dataSrc": "",
          "data": {
            "fecha_inicial": fecha_inicial,
            "fecha_final": fecha_final,
            "sucursal": sucursal,
            "codigo": codigo
          },
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "tipo_mov"
          },
          {
            "data": "fecha"
          },
          {
            "data": "cantidad"
          }
        ]
      });
    }
  </script>
  <script type="text/javascript">
    $('#c_comprada').dblclick(function() {
      cargar_tabla();
      $('#div_compras').removeAttr('style');
    });

    $('#e_trans').dblclick(function() {
      cargar_tabla_e_trans();
      $('#div_e_transf').removeAttr('style');
    });

    $('#u_mermas').dblclick(function() {
      cargar_mermas();
      $('#div_mermas').removeAttr('style');
    });
    $('#ae_trans').dblclick(function() {
      cargar_aetrans();
      $('#div_aetrans').removeAttr('style');
    });
    $('#lbl_altas_inventario').dblclick(function() {
      cargar_ainventario();
      $('#div_altas_inv').removeAttr('style');
    });
    $('#salidas_x_transf').dblclick(function() {
      cargar_salidas_x_transf();
      $('#div_salidas_transf').removeAttr('style');
    });
    $('#astrans').dblclick(function() {
      cargar_astrans();
      $('#div_astrans').removeAttr('style');
    });
    $('#b_i').dblclick(function() {
      cargar_bi();
      $('#div_bi').removeAttr('style');
    });
    $('#lbl_separado').dblclick(function() {
      cargar_separado();
      $('#div_separado').removeAttr('style');
    });
    $('#lbl_ajustes_f').dblclick(function() {
      cargar_ajustes();
      $('#div_ajustes').removeAttr('style');
    });
  </script>
</body>

</html>