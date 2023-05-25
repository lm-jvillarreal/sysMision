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

<body class="hold-transition skin-red sidebar-mini" onload="">
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
            <h3 class="box-title">Compras | Consulta de Articulos</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="frmDatos">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label id="lblcodigo">*Codigo</label>
                    <input type="text" id="codigo" name="codigo" class="form-control">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                  <div class="form-group">
                    <label id="lblDescripcion" for="descripcion">*Descripcion</label>
                    <input type="text" name="descripcion" id="artc_descripcion" readonly class="form-control">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label for="bodega" id='lblPP'>*Precio Publico</label>
                    <input readonly class="form-control" type="text" id="precio_publico">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                  <div class="form-group">
                    <label id="lblOferta" for="bodega">Oferta</label>
                    <input class="form-control" type="text" readonly name="descripcion" id="precio_oferta">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label for="bodega">Hasta el:</label>
                    <input type="text" class="form-control" readonly name="" id="fecha_fin">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <label>IVA</label>
                  <input type="text" readonly class="form-control" id="iva" name="">
                </div>
                <div class="col-md-2">
                  <label>IEPS</label>
                  <input type="text" readonly class="form-control" id="ieps" name="">
                </div>
                <div class="col-md-2">
                  <label>Ultimo Costo</label>
                  <input type="text" class="form-control" readonly id="u_c">
                </div>
                <div class="col-md-2">
                  <label>Margen PP</label>
                  <input type="text" id="m_pp" readonly class="form-control">
                </div>
                <div class="col-md-2">
                  <label>Margen PO</label>
                  <input type="text" class="form-control" readonly id="m_po">
                </div>
                <div class="col-md-2">
                  <label id="lblExistencia">Existencia</label>
                  <input type="text" readonly class="form-control" id="existencia">
                </div>
              </div>
            </form>
          </div>
          <div class="box box-footer">
            <div class="row">
              <div class="col-md-4 text-left">
                <button onclick="cargar_tabla()" class="btn btn-danger">Historial de Traspasos</button>
              </div>
              <div class="col-md-4 text-right">
                <button id="btnEntradas" class="btn btn-danger">Historial de entradas</button>
              </div>
              <div class="col-md-4 text-right">
                <button id="btnESCARG" class="btn btn-danger">Historial de ESCARG</button>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista del Proveedor</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_proveedor" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='10%'>Cve. Prov.</th>
                        <th>Nombre Prov.</th>
                        <th width='10%'>Articulo</th>
                        <th>Descripcion</th>
                        <th width='10%'>Costo</th>
                        <th width='10%'>Costo Base</th>
                        <th width='7%'>% Desc1</th>
                        <th width='7%'>% Desc2</th>
                        <th width='7%'>% Desc3</th>
                        <th width='7%'>% Desc4</th>
                        <th width='7%'>% Desc5</th>
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
            <h3 class="box-title">Historial de entradas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_entradas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Fecha</th>
                        <th>Tipo Mov</th>
                        <th>Folio</th>
                        <th>PU</th>
                        <th>Cant</th>
                        <th>Total</th>
                        <th>Sucursal Afectada</th>
                        <th>Proveedor</th>
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
            <h3 class="box-title">Consulta de Artículos | Historial de Traspasos de Entrada</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_traspasos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='10%'>Id. Trans</th>
                        <th width='5%'>Mov.</th>
                        <th width='10%'>Folio Mov.</th>
                        <th width='10%'>Folio Salida</th>
                        <th width='10%'>Cant. Salida</th>
                        <th width='12%'>Folio Entrada</th>
                        <th width='12%'>Cant. Entrada</th>
                        <th width='10%'>Origen</th>
                        <th width='10%'>Destino</th>
                        <th width='10%'>Fecha</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </section>
    </div>
    <?php include '../footer2.php'; ?>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <?php include '../footer.php'; ?>
  <?php
  include 'modal_ofertas.php';
  include 'modal_cantidades.php';
  include 'modal_buscar.php';
  include 'modal.php';
  include 'modal_precio.php'
  ?>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

  <script>
    function cargar_tabla() {
      var codigo = $("#codigo").val();
      $('#lista_traspasos').dataTable().fnDestroy();
      $('#lista_traspasos').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "order": [
          [0, "desc"]
        ],
        "dom": 'Bfrtip',
         buttons: [
          {
						extend: 'pageLength',
						text: 'Registros',
						className: 'btn btn-default'
					},
					{
						extend: 'excel',
						text: 'Exportar a Excel',
						className: 'btn btn-default',
						title: 'Modulos-Lista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'Modulos-Lista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'copy',
						text: 'Copiar registros',
						className: 'btn btn-default',
						copyTitle: 'Ajouté au presse-papiers',
						copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
						copySuccess: {
							_: '%d lignes copiées',
							1: '1 ligne copiée'
						}
					}
				],
        "ajax": {
          "type": "POST",
          "url": "tabla_traspasos.php",
          "dataSrc": "",
          "data": {
            codigo: codigo
          }
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "movimiento"
          },
          {
            "data": "folio_mov"
          },
          {
            "data": "folio_salida"
          },
          {
            "data": "cantidad_salida"
          },
          {
            "data": "folio_entrada"
          },
          {
            "data": "cantidad_entrada"
          },
          {
            "data": "origen"
          },
          {
            "data": "destino"
          },
          {
            "data": "fecha"
          }
        ]
      });
    }

    function cargar_entradas(tipomov) {
      var codigo = $("#codigo").val();
      $('#lista_entradas').dataTable().fnDestroy();
      $('#lista_entradas').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        buttons: [{
            extend: 'pageLength',
            text: 'Registros',
            className: 'btn btn-default'
          },
          {
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'FaltantesLista',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'FaltantesLista',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'copy',
            text: 'Copiar registros',
            className: 'btn btn-default',
            copyTitle: 'Ajouté au presse-papiers',
            copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
            copySuccess: {
              _: '%d lignes copiées',
              1: '1 ligne copiée'
            }
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_entradas.php",
          "dataSrc": "",
          "data": {
            codigo: codigo,
            tipomov: tipomov
          }
        },
        "columns": [{
            "data": "fecha"
          },
          {
            "data": "tipo_mov"
          },
          {
            "data": "folio"
          },
          {
            "data": "pu"
          },
          {
            "data": "cant"
          },
          {
            "data": "total"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "proveedor"
          }
        ]
      });
    }
    $('#codigo').change(function() {
      var codigo = $('#codigo').val();
      cargar_lista();
      $.ajax({
        data: {
          'codigo': codigo
        }, //datos que se envian a traves de ajax
        url: 'consulta_codigo.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        beforeSend: function() {},
        success: function(response) {
          var array = eval(response);
          $('#artc_descripcion').val(array[0]);
          $('#precio_oferta').val(array[1]);
          $('#fecha_fin').val(array[3]);
          $('#precio_publico').val(array[4]);
          $('#u_c').val(array[5]);
          $('#iva').val(array[6]);
          $('#ieps').val(array[7]);
          $('#m_pp').val(array[8]);
          $('#m_po').val(array[9]);
          $('#existencia').val(array[10]);
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
        },
        success: function(response) {
          $('#formulario').show();
          $('#cargando').hide();
          var array = eval(response);
          $('#cantidad_comprada').val(array[0]);
          $('#entradas_transf').val(array[1]);
          $('#altas_inventario').val(array[2]);
          $('#devolucion_venta').val(array[3]);
          $('#ajustes_forzosos').val(array[4]);
          $('#cantidad_vendida').val(array[5]);
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
          suma_entrada();
          suma_salidas();
          calcular_teorico();
          existencia_real();
          diferencia();
          suma_entrada();
          suma_salidas();
          existencia_real();
        }
      });
    });

    function suma_entrada() {
      var comprada = $('#cantidad_comprada').val();
      var entradas_transf = $('#entradas_transf').val();
      var altas_inventario = $('#altas_inventario').val();
      var devolucion_venta = $('#devolucion_venta').val();
      var mermas = $('#mermas').val();
      var total = parseFloat(comprada) + parseFloat(entradas_transf) + parseFloat(altas_inventario) + parseFloat(devolucion_venta) + parseFloat(mermas);
      $('#total_entradas').val(total);
    }

    function suma_salidas() {
      var venta = $('#cantidad_vendida').val();
      var salida_transf = $('#salidas_transf').val();
      var bajas_inv = $('#bajas_inventario').val();
      var devolucion_compra = $('#devolucion_compra').val();
      var salida_transf = $('#salida_restaurante').val();
      var total = parseFloat(venta) + parseFloat(salida_transf) + parseFloat(bajas_inv) + parseFloat(devolucion_compra) + parseFloat(salida_transf);
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
      var teorico_final = parseFloat(teorico) - parseFloat(pendientes) - parseFloat(v_proceso);
      $('#teorico_final').val(teorico_final);
    }

    function calcular_teorico() {
      var inicial = $('#inv_inicial').val();
      var entradas = $('#total_entradas').val();
      var salidas = $('#total_salidas').val();
      var teorico_calc = (parseFloat(inicial) + parseFloat(entradas)) - parseFloat(salidas);
      $('#teorico_calc').val(teorico_calc);
    }

    function detalle_ofertas(codigo) {

      $.ajax({
        data: {
          'codigo': codigo
        }, //datos que se envian a traves de ajax
        url: 'consulta_codigo_ofertas.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        beforeSend: function() {
          // alert("Buscando");
          // $('#contenedor_tabla').hide();
          // $('#cargando_barra').show();
        },
        success: function(response) {
          $('#modal_ofertas').modal('show');
          var array = eval(response);
          $('#o_do').val(array[0]);
          $('#o_arb').val(array[1]);
          $('#o_vil').val(array[2]);
          $('#o_all').val(array[3]);
          $('#o_pet').val(array[4]);
          $('#o_mm').val(array[5]);
        }
      });
    }

    function exis_suc(codigo) {

      $.ajax({
        data: {
          'codigo': codigo
        }, //datos que se envian a traves de ajax
        url: 'consulta_existencias.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        beforeSend: function() {
          // alert("Buscando");
          // $('#contenedor_tabla').hide();
          // $('#cargando_barra').show();
        },
        success: function(response) {
          $('#cantidades').modal('show');
          var array = eval(response);
          $('#ex_diaz').val(array[0]);
          $('#ex_arboledas').val(array[1]);
          $('#ex_villegas').val(array[2]);
          $('#ex_allende').val(array[3]);
          $('#ex_lp').val(array[4]);
          $('#ex_mm').val(array[5]);
          $('#ex_cedis').val(array[6]);
          $('#ex_cedisRopa').val(array[7]);
        }
      });
    }

    function buscar(descripcion) {
      $.ajax({
        data: {
          'descripcion': descripcion
        }, //datos que se envian a traves de ajax
        url: 'tabla_articulos.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        beforeSend: function() {
          // alert("Buscando");
          // $('#contenedor_tabla').hide();
          // $('#cargando_barra').show();
        },
        success: function(response) {
          $('#modal_buscar').modal('show');
          $('#modal_contenedor').html(response);
        }
      });

    }

    function mas_datos(codigo) {
      $.ajax({
        data: {
          'codigo': codigo
        }, //datos que se envian a traves de ajax
        url: 'consulta_codigo_extras.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        beforeSend: function() {
          // alert("Buscando");
          // $('#contenedor_tabla').hide();
          // $('#cargando_barra').show();
        },
        success: function(response) {
          $('#modificar_cantidad').modal('show');
          var array = eval(response);
          $('#modal_dpto').val(array[5]);
          $('#modal_familia').val(array[4]);
          $('#modal_um').val(array[1]);
          $('#fecha_alta').val(array[0]);
          $('#cve_sat').val(array[2]);
          $('#estatus').val(array[3]);
        }
      });
    }
    $('#lblcodigo').dblclick(function() {
      var codigo = $('#codigo').val();
      mas_datos(codigo);
    });
    $('#lblOferta').dblclick(function() {
      var codigo = $('#codigo').val();
      detalle_ofertas(codigo);
    });
    $('#lblExistencia').dblclick(function() {
      var codigo = $('#codigo').val();
      exis_suc(codigo);
    });
    $('#lblDescripcion').dblclick(function() {
      var descripcion = $('#artc_descripcion').val();
      buscar(descripcion);
    });

    $("#btnEntradas").click(function() {
      cargar_entradas("entradas");
    })
    $("#btnESCARG").click(function(){
      cargar_entradas("ESCARG");
    });
    $("#lblPP").dblclick(function(){
      var codigo = $("#codigo").val();
      preciopub();
    })

    function cargar_lista() {
      var codigo = $("#codigo").val();
      $('#lista_proveedor').dataTable().fnDestroy();
      $('#lista_proveedor').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_listaProveedor.php",
          "dataSrc": "",
          "data": {
            codigo: codigo
          }
        },
        "columns": [{
            "data": "cve_prov"
          },
          {
            "data": "prov"
          },
          {
            "data": "codigo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "costo"
          },
          {
            "data": "costo_base"
          },
          {
            "data": "desc1"
          },
          {
            "data": "desc2"
          },
          {
            "data": "desc3"
          },
          {
            "data": "desc4"
          },
          {
            "data": "desc5"
          },
        ]
      });
    }

    function preciopub() {
      var url = "consulta_precio.php";
      var artc_articulo = $("#codigo").val();
      if (artc_articulo == "") {

      } else {
        $.ajax({
          data: {
            'codigo': artc_articulo
          }, //datos que se envian a traves de ajax
          url: url, //archivo que recibe la peticion
          type: 'POST', //método de envio
          dateType: 'html',
          success: function(response) {
            $('#modal_precio').modal('show');
            var array = eval(response);
            $('#do_precio').val(array[0]);
            $('#arb_precio').val(array[1]);
            $('#vill_precio').val(array[2]);
            $('#all_precio').val(array[3]);
            $('#pet_precio').val(array[4]);
            $('#mm_precio').val(array[5]);
          }
        });
      }
    }
  </script>

</body>

</html>