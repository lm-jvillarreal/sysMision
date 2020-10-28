<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
$hora = date("h:i:s");
?>
<!DOCTYPE html>
<html>

<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <?php include '../head.php'; ?>
</head>

<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <?php include '../header.php'; ?>
    </header>
    <aside class="main-sidebar">
      <?php include 'menuV.php'; ?>
    </aside>
    <div class="content-wrapper">
      <section class="content">
        <div id="tabla">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Sistemas | Ajustes de inventario</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div>
                  <form id="frmDatosAjustes">
                    <input type="hidden" name="codigos" id="codigos">
                    <input type="hidden" id="cantidades" name="cantidades">
                    <div class="col-lg-3">
                      <label>Archivo</label>
                      <input type="file" name="excel">
                    </div>
                    <div class="col-md-3">
                      <label>Folio</label>
                      <input type="hidden" value="upload" name="action" />
                      <input type="text" id="folio" name="folio" class="form-control">
                    </div>
                    <div class="col-md-3">
                      <label>Sucursal</label>
                      <select name="sucursal" id="sucursal" class="form-control">
                        <option selected disabled>Selecciona...</option>
                        <option value="1">Diaz Ordaz</option>
                        <option value="2">Arboledas</option>
                        <option value="3">Villegas</option>
                        <option value="4">Allende</option>
                        <option value="5">Petaca</option>
                        <option value="99">CEDIS</option>
                        <option value="202">REST.AR</option>
                        <option value="402">REST.ALL</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label>Movimiento</label>
                      <select class="form-control" id="movimiento" name="movimiento">
                        <option disabled selected>Selecciona...</option>
                        <option value="ENTGRA">Entrada Cortes</option>
                        <option value="EGRAL">Entrada General Sistemas</option>
                      </select>
                    </div>
                  </form>
                </div>
              </div>
              <br>
            </div>
            <div class="box-footer">
              <div class="row">
                <div class='col-md-6 text-left'>
                  <a href="importador_supsys.xlsx" class="btn btn-default">Descargar Importador</a>
                </div>
                <div class='col-md-6 text-right'>
                  <a href="#" onclick="subir_excel()" class="btn btn-danger">Importar Archivo</a>
                  <a href="#" onclick="javascript:validar_folio()" class="btn btn-warning">Insertar Registros</a>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  </section>
  </div>
  <?php include '../footer2.php'; ?>
  <div class="control-sidebar-bg"></div>
  </div>
  <?php include '../footer.php'; ?>
  <script>
    //llenarRequisicion();
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });
    $('#movimiento').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
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

    function subir_excel() {
      subir_excel2();
      var parametros = new FormData($("#frmDatosAjustes")[0]);
      $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: 'importar.php', //archivo que recibe la peticion
        type: 'post', //método de envio
        contentType: false,
        processData: false,
        success: function(response) {
          Swal.fire(
            'Excel importado!',
            'Da clic en registrar!',
            'success'
          );
          //alert("Codigos listos, da click en registrar");
          var array = eval(response);
          $('#codigos').val(array);
          var jObject = array.toString();
        }

      });
    }

    function subir_excel2() {
      var parametros = new FormData($("#frmDatosAjustes")[0]);
      $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: 'importar2.php', //archivo que recibe la peticion
        type: 'post', //método de envio
        contentType: false,
        processData: false,
        success: function(response) {
          var array = eval(response);
          $('#cantidades').val(array);
          var jObject = array.toString();
        }

      });
    }

    function insertar() {
      $.ajax({
        url: "insertar_registro.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatosAjustes').serialize(),
        success: function(respuesta) {
          //alert(respuesta);
          Swal.fire(
            'Exito!',
            'Registros insertados!',
            'success'
          );

          //alert("Codigos insertados");
        },
        error: function(xhr, status) {
          alert(xhr);
        },
      });
    }

    function validar_folio() {
      var folio = $('#folio').val();
      var sucursal = $('#sucursal').val();
      var movimiento = $('#movimiento').val();
      $.ajax({
        data: {
          'folio': folio,
          'sucursal': sucursal,
          'movimiento': movimiento
        }, //datos que se envian a traves de ajax
        url: 'consulta_folio.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        dateType: 'html',
        success: function(response) {
          //alert(response);
          if (response == "true") {
            insertar();
          } else {
            Swal.fire({
              type: 'error',
              title: 'Oops...',
              text: 'Este folio no existe!',
              footer: '<a href></a>'
            });
          }
        }
      });
    }
  </script>
</body>

</html>