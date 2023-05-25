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
            <h3 class="box-title">Remisiones Internas | Registro</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="proveedor">Proveedor:</label>
                  <select name="proveedor" id="proveedor" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="guardar">Generar Remisión</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Remisiones Internas | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_remisiones" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='8%'>Folio</th>
                        <th>Proveedor</th>
                        <th width='10%'>Sucursal</th>
                        <th width="8%">Fecha</th>
                        <th width="5%">Estatus</th>
                        <th width="5%">Usuario</th>
                        <th width='15%'></th>
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
    <?php include 'modal_agregar.php'; ?>
    <?php include 'modal_cancelar.php'; ?>
    <?php include 'modal_asignar.php'; ?>
    <?php include '../footer2.php'; ?>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <?php include '../footer.php'; ?>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <!-- Page script -->
  <script>
    $(document).ready(function() {
      cargar_tabla();
    })
    $('#proveedor').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_proveedor.php",
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
    });
    $('#tipo_movimiento').select2({
      width: '100%',
      dropdownParent: $("#modal-asociar"),
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity,
    });
    $("#guardar").click(function() {
      var proveedor = $("#proveedor").val();
      var nombre_proveedor = $("#proveedor").text();
      var url = 'insertar_remision.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          proveedor: proveedor,
          nombre_proveedor: nombre_proveedor
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Registro insertado correctamente");
            cargar_tabla();
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    });

    function cargar_tabla() {
      $('#lista_remisiones').dataTable().fnDestroy();
      $('#lista_remisiones').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "order": [
          [0, "asc"]
        ],
        "searching": true,
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
          "url": "tabla_remision.php",
          "dataSrc": "",
          "data": ""
        },
        "columns": [{
            "data": "remision"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "fecha"
          },
          {
            "data": "estatus"
          },
          {
            "data": "usuario"
          },
          {
            "data": "opciones"
          }
        ]
      });
    }

    function tabla_detalle(id_remision) {
      $("#lista_articulos").dataTable().fnDestroy();
      $("#lista_articulos").dataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "searching": false,
        "order": [
          [0, "asc"]
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_detalle.php",
          "dataSrc": "",
          "data": {
            id_remision: id_remision
          }
        },
        "columns": [{
            "data": "cantidad",
            "width": "10%"
          },
          {
            "data": "artc_articulo",
            "width": "70%"
          },
          {
            "data": "costo_unitario",
            "width": "10%"
          },
          {
            "data": "costo_total",
            "width": "10%"
          }
        ]
      });
    }

    function ver(id_remision, folio_remision) {
      $("#modal-agregar").modal("show");
      $("#id").val(id_remision);
      $("#remision").val("R-" + folio_remision);
      tabla_detalle(id_remision);
    }
    $('#modal-agregar').on('shown.bs.modal', function() {
      $("#cantidad").val("");
      $("#artc_articulo").val("");
      $("#costo_unitario").val("");
      $("#cantidad").focus();
    });
    $("#cantidad").keypress(function(e) {
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        if ($("#cantidad").val() == "") {
          $("#cantidad").focus();
        } else {
          $("#artc_articulo").focus();
        }
      }
    });
    $("#artc_articulo").keypress(function(e) {
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        if ($("#artc_articulo").val() == "") {
          $("#artc_articulo").focus();
        } else {
          $("#costo_unitario").focus();
        }
      }
    });
    $("#costo_unitario").keypress(function(e) {
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        if ($("#costo_unitario").val() == "") {
          $("#costo_unitario").focus();
        } else {
          var url = "insertar_detalle.php";
          var id = $("#id").val();
          var cantidad = $("#cantidad").val();
          var artc_articulo = $("#artc_articulo").val();
          var costo_unitario = $("#costo_unitario").val();
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {
              id: id,
              cantidad: cantidad,
              artc_articulo: artc_articulo,
              costo_unitario: costo_unitario
            },
            success: function(respuesta) {
              alertify.success("Artículo agregado correctamente");
              tabla_detalle(id);
              $("#cantidad").val("");
              $("#artc_articulo").val("");
              $("#costo_unitario").val("");
              $("#cantidad").focus();
            },
            error: function(xhr, status) {
              alert("error");
              //alert(xhr);
            },
          })
        }
      }
    });

    function abrir(id_remision, folio_remision, proveedor) {
      window.open("remision.php?tckt=" + id_remision + "&remision=" + folio_remision + "&proveedor=" + proveedor, "remision", "width=290,height=900,menubar=no,titlebar=no");
    }
    $("#finalizar").click(function() {
      abrir($("#id").val(), $("#remision").val());
      $("#modal-agregar").modal("toggle");
    })

    function baja(id_remision, remision) {
      $("#modal-cancelar").modal("show");
      $("#id_cancelar").val(id_remision);
      $("#remision_cancelar").val(remision);
    }
    $("#cancelar_remision").click(function() {
      if ($("#motivo").val() == "") {
        alertify.error("Favor de ingresar un motivo");
      } else {
        var url = "cancelar_remision.php";
        var id_remision = $("#id_cancelar").val();
        var motivo = $("#motivo").val();
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: {
            id_remision: id_remision,
            motivo: motivo
          },
          success: function(respuesta) {
            alertify.success("Remisión cancelada correctamente");
            $("#modal-cancelar").modal("toggle");
            cargar_tabla();
            llenar_notificaciones();
          },
          error: function(xhr, status) {
            alert("error");
            //alert(xhr);
          },
        })
      }
    })

    function asociar(id_remision, remision) {
      $("#modal-asociar").modal("show");
      $("#id_asociar").val(id_remision);
      $("#remision_asociar").val(remision);
    }

    $("#asociar_remision").click(function() {
      var url = "asociar_remision.php";
      var id_remision = $("#id_asociar").val();
      var tipo_movimiento = $("#tipo_movimiento").val();
      var folio_movimiento = $("#folio_movimiento").val();
      if (folio_movimiento == "" || tipo_movimiento == "") {
        alertify.error("Favor de proporcionar todos los datos necesarios");
      } else {
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: {
            id_remision: id_remision,
            tipo_movimiento: tipo_movimiento,
            folio_movimiento: folio_movimiento
          },
          success: function(respuesta) {
            if (respuesta == "no_existe") {
              alertify.error("El movimiento no existe");
              $("#modal-asociar").modal("toggle");
              cargar_tabla();
            } else if (respuesta == "ok") {
              alertify.success("Remisión asociada correctamente");
              $("#modal-asociar").modal("toggle");
              cargar_tabla();
              llenar_notificaciones();
            }
          },
          error: function(xhr, status) {
            alert("error");
            //alert(xhr);
          },
        })
      }
    });
    $("#no_aplica").click(function() {
      var url = "no_asociar.php";
      var id_remision = $("#id_asociar").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_remision: id_remision
        },
        success: function(respuesta) {
          alertify.success("Remisión liberada correctamente");
          $("#modal-asociar").modal("toggle");
          cargar_tabla();
          llenar_notificaciones();
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
    })
  </script>
</body>

</html>