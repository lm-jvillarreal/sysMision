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
              <h3 class="box-title">Facturas y cheques | Tabla</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                  <label>Factura</label>
                  <input type="text" name="factura" id="factura" onchange="javascript:consultar($(this).val())" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Datos</h3>
            </div>
            <div class="box-body" id="div_separado">
              <div class="table-responsive">
                <table id="lista_cheques" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Clave</th>
                      <th>Proveedor</th>
                      <th>Factura</th>
                      <th>Importe</th>
                      <th># de cheque</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Clave</th>
                      <th>Proveedor</th>
                      <th>Factura</th>
                      <th>Importe</th>
                      <th># de cheque</th>
                    </tr>
                  </tfoot>
                </table>
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

  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
	
  <script src="funciones.js"></script>
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
    function consultar(factura) {
      $('#lista_cheques').dataTable().fnDestroy();
      $('#lista_cheques').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },        
        "paging": false,
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
              title: 'Lista Proveedores',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'Lista Proveedores',
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
          "url": "datos.php",
          "dataSrc": "",
          "data": {
            "factura": factura
          },
        },
        "columns": [{
            "data": "clave"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "factura"
          },
          {
            "data": "importe"
          },
          {
            "data": "cheque"
          }
        ]
      });
    }
  </script>
</body>

</html>