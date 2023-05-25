<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <link href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.bootstrap4.min.css" rel="stylesheet" />
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
            <h3 class="box-title">Reportes | Faltante por Existencia</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datoss" action="rpt_faltante_existencia.php">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="sucursal">*Sucursal:</label>
                    <select name="sucursal" id="sucursal" class="form-control select">
                      <option value=""></option>
                      <option value="1">Díaz Ordaz</option>
                      <option value="2">Arboledas</option>
                      <option value="3">Villegas</option>
                      <option value="4">Allende</option>
                      <option value="5">Petaca</option>
                      <option value="6">Montemorelos</option>
                      <option value="99">CEDIS</option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="mostrar_datos">Mostrar datos</button>
            <button class="btn btn-danger" id="btnGenerar">Generar Excel</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Reportes | Faltante por Existencia</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_faltantes" class="table table-striped table-bordered" cellspacing="0" width="120%">
                    <thead>
                      <tr>
                        <th width='10%'>Artículo</th>
                        <th>Descripción</th>
                        <th width='8%'>Cant. Afectar</th>
                        <th width='8%'>Existencia</th>
                        <th width='5%'>Faltante</th>
                        <th width='5%'>ENTCOC</th>
                        <th width='5%'>ENTSOC</th>
                        <th width='5%'>ENTTRA</th>
                        <th width='5%'>ETRANS</th>
                        <th width='5%'>SIROTA</th>
                        <th width='30' 5>Departamento</th>
                        <th width='5%'></th>
                      </tr>
                    </thead>
                  </table>
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
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/fixedcolumns/3.2.4/js/dataTables.fixedColumns.min.js"></script>
  <script>
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
    $("#btnGenerar").click(function() {
      $("#form_datoss").submit();
    });
    $("#mostrar_datos").click(function() {
      tabla_detalle();
    })

    function tabla_detalle() {
      var sucursal = $("#sucursal").val();
      $('#lista_faltantes').dataTable().fnDestroy();
      $('#lista_faltantes').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        fixedColumns: {
          leftColumns: 2,
          rightColumns: 1
        },
        "scrollX": true,
        "scrollY": "300px",
        "scrollCollapse": true,
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
						title: 'ListaCategorias',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'ListaCategorias',
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
          "url": "tabla_faltantes.php",
          "dataSrc": "",
          data: {
            sucursal: sucursal
          }
        },
        "columns": [{
            "data": "artc_articulo"
          },
          {
            "data": "artc_descripcion"
          },
          {
            "data": "cantidad_afectar"
          },
          {
            "data": "existencia"
          },
          {
            "data": "faltante"
          },
          {
            "data": "entcoc"
          },
          {
            "data": "entsoc"
          },
          {
            "data": "enttra"
          },
          {
            "data": "etrans"
          },
          {
            "data": "sirota"
          },
          {
            "data": "depto"
          },
          {
            "data": "revision"
          }
        ]
      });
    };

    function revisar(artc_articulo, artc_descripcion, sucursal, depto, teorico) {
      var url = 'enviar_revision.php';
      swal({
          closeOnClickOutside: false,
          closeOnEsc: false,
          title: "Ingresa un comentario para la revisión",
          content: {
            element: "input",
            placeholder: "Ingresa aqui el comentario",
            required: "true",
          }
        })
        .then((value) => {
          $.ajax({
            type: "POST",
            url: url,
            data: {
              artc_articulo: artc_articulo,
              artc_descripcion: artc_descripcion,
              sucursal: sucursal,
              depto: depto,
              teorico: teorico,
              comentario: `${value}`
            }, // Adjuntar los campos del formulario enviado.
            success: function(respuesta) {
              swal("El articulo ha sido enviado a revisión correctamente.", {
                icon: "success",
              });
            }
          });

        })

      return false;
    }
  </script>
</body>

</html>