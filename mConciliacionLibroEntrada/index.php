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
            <h3 class="box-title">Conciliación de Libro de Entrada | Registro</h3>
          </div>
          <div class="box-body">
            <form action="" id="form-datos">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="ficha_entrada">*Ficha de entrada</label>
                    <input type="hidden" id="id_ficha" name="id_ficha">
                    <input type="text" name="ficha_entrada" id="ficha_entrada" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="clave_proveedor">Clave Proveedor</label>
                    <input type="text" name="clave_proveedor" id="clave_proveedor" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nombre_proveedor">Nombre Proveedor</label>
                    <input type="text" name="nombre_proveedor" id="nombre_proveedor" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="remision">Remisión</label>
                    <input type="text" name="remision" id="remision" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="total_remision">Total remisión</label>
                    <input type="text" name="total_remision" id="total_remision" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="total_entrada">Total entrada</label>
                    <input type="text" name="total_entrada" id="total_entrada" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="total_devoluciones">Total devoluciones</label>
                    <input type="text" name="total_devoluciones" id="total_devoluciones" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="total_cf">Total CF</label>
                    <input type="text" name="total_cf" id="total_cf" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="total_nc">Total DC (-)</label>
                    <input type="text" name="total_nc" id="total_nc" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="total_nc2">Total DC (+)</label>
                    <input type="text" name="total_nc2" id="total_nc2" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="gran_total">Gran total</label>
                    <input type="text" name="gran_total" id="gran_total" class="form-control" readonly="true">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="total_diferencia">Diferencia</label>
                    <input type="text" name="diferencia" id="diferencia" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="escaneada">*Escaneada:</label>
                    <select name="escaneada" id="escaneada" class="form-control">
                      <option value=""></option>
                      <option value="1">Si</option>
                      <option value="0">No</option>
                    </select>
                  </div>
                </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-danger" id="btnFinalizar">Finalizar Conciliación</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <div class="row">
              <div class="col-md-6">
                <h3 class="box-title">Conciliación de Libro de Entrada | Folios de Movimientos</h3>
              </div>
              <div class="col-md-6">
                <h3 class="box-title">Conciliación de Libro de Entrada | Cartas Faltantes</h3>
              </div>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="table-responsive">
                  <table id="lista_folios" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <th width='10%'>Folio</th>
                      <th>Tipo Mov</th>
                      <th width='10%'>Monto</th>
                      <th width='5%'></th>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-6">
                <div class="table-responsive">
                  <table id="lista_cf" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <th width='10%'>Folio</th>
                      <th>Tipo</th>
                      <th width='10%'>Monto</th>
                      <th width='20%'></th>
                      <th width='10%'></th>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <div class="row">
              <div class="col-md-6">
                <h3 class="box-title">Conciliación de Libro de Entrada | Dif. Costo</h3>
              </div>
              <div class="col-md-6">
                <h3 class="box-title">Conciliación de Libro de Entrada | ESCARG</h3>
              </div>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="table-responsive">
                  <table id="lista_notasCargo" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <th width='10%'>Folio</th>
                      <th>Tipo Mov</th>
                      <th width='10%'>Monto</th>
                      <th width='5%'></th>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-6">
                <div class="table-responsive">
                  <table id="lista_escarg" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <th width='10%'>Folio</th>
                      <th>Tipo Mov</th>
                      <th width='10%'>Monto</th>
                      <th width='5%'></th>
                    </thead>
                    <tbody></tbody>
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
    <?php include 'modal_folios.php'; ?>
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
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <!-- Page script -->
  <script>
    $("#escaneada").select2({
      placeholder: "Selecciona ..."
    });
    $(document).ready(function() {
      $("#ficha_entrada").focus();
      tabla_folios();
      tabla_cf();
      tabla_nc();
      tabla_escarg();
    })
    $("#ficha_entrada").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_ficha.php"; // El script a dónde se realizará la petición.
        var ficha_entrada = $("#ficha_entrada").val();
        $.ajax({
          type: "POST",
          url: url,
          data: {
            ficha_entrada: ficha_entrada
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "no") {
              alertify.error("El folio ingresado no existe");
              $('#ficha_entrada').val("");
            }
            var array = eval(respuesta);
            $("#clave_proveedor").val(array[0]);
            $("#nombre_proveedor").val(array[1]);
            $("#remision").val(array[2]);
            $("#total_remision").val(array[3]);
            $("#id_ficha").val(array[4]);
            tabla_folios();
            tabla_cf();
            tabla_nc();
            tabla_escarg();
            totales();
          }
        });
        return false;
      }
    });
    $("#total_remision").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        totales();
        return false;
      }
    });

    function tabla_folios() {
      var ficha_entrada = $("#ficha_entrada").val();
      $('#lista_folios').dataTable().fnDestroy();
      $('#lista_folios').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "searching": false,
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
            title: 'AuditoriaPV',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'AuditoriaPV',
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
          {
            text: 'Ingresar folio',
            action: function() {
              ingresarFolio();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_folios.php",
          "data": {
            ficha_entrada: ficha_entrada
          },
          "dataSrc": ""
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "tipo_movimiento"
          },
          {
            "data": "monto"
          },
          {
            "data": "opciones"
          }
        ]
      });
    };

    function tabla_cf() {
      var ficha_entrada = $("#ficha_entrada").val();
      $('#lista_cf').dataTable().fnDestroy();
      $('#lista_cf').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "searching": false,
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
            title: 'AuditoriaPV',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'AuditoriaPV',
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
          "url": "tabla_cf.php",
          "data": {
            ficha_entrada: ficha_entrada
          },
          "dataSrc": ""
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "tipo"
          },
          {
            "data": "monto"
          },
          {
            "data": "opciones"
          },
          {
            "data": "estatus"
          }
        ]
      });
    };

    function tabla_nc() {
      var ficha_entrada = $("#ficha_entrada").val();
      $('#lista_notasCargo').dataTable().fnDestroy();
      $('#lista_notasCargo').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "searching": false,
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
            title: 'AuditoriaPV',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'AuditoriaPV',
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
          "url": "tabla_nc.php",
          "data": {
            ficha_entrada: ficha_entrada
          },
          "dataSrc": ""
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "tipo"
          },
          {
            "data": "monto"
          },
          {
            "data": "opciones"
          }
        ]
      });
    };

    function tabla_escarg() {
      var ficha_entrada = $("#ficha_entrada").val();
      $('#lista_escarg').dataTable().fnDestroy();
      $('#lista_escarg').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "searching": false,
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
            title: 'AuditoriaPV',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'AuditoriaPV',
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
          "url": "tabla_escarg.php",
          "data": {
            ficha_entrada: ficha_entrada
          },
          "dataSrc": ""
        },
        "columns": [{
            "data": "artc_articulo"
          },
          {
            "data": "artc_descripcion"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "opciones"
          }
        ]
      });
    };

    function ingresarFolio() {
      var ficha_entrada = $("#ficha_entrada").val();
      if (ficha_entrada == "") {
        swal("Folio de movimientos", "Un folio debe pertenecer a una ficha de entrada", "error");
      } else {
        $("#modal-codigos").modal("show");
      }
    }
    $("#btnGuardarModal").click(function() {
      if ($("#modc_tipomov").val() == "" || $("#modn_folio").val() == "") {
        $('#modal-codigos').modal('toggle');
      } else {
        var modc_tipomov = $("#modc_tipomov").val();
        var modn_folio = $("#modn_folio").val();
        var ficha_entrada = $("#ficha_entrada").val();
        var id_ficha = $("#id_ficha").val();
        var url = 'insertar_folio.php';
        $.ajax({
          type: "POST",
          url: url,
          data: {
            modc_tipomov: modc_tipomov,
            modn_folio: modn_folio,
            ficha_entrada: ficha_entrada,
            id_ficha: id_ficha
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            $('#modal-codigos').modal('toggle');
            alertify.success("El folio de movimiento ha sido registrado");
            tabla_folios();
            tabla_nc();
            totales();
            $('#escaneada').val(null).trigger('change');
          }
        });
      }
      return false;
    });
    $('#modc_tipomov').select2({
      width: '100%',
      dropdownParent: $("#modal-codigos"),
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
    });

    function totales() {
      if ($("#ficha_entrada").val() == "") {

      } else {
        var ficha_entrada = $("#ficha_entrada").val();
        var url = "consulta_totales.php";
        $.ajax({
          type: "POST",
          url: url,
          data: {
            ficha_entrada: ficha_entrada
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            var array = eval(respuesta);
            $("#total_entrada").val(array[0]);
            $("#total_devoluciones").val(array[1]);
            $("#total_cf").val(array[2]);
            $("#total_nc").val(array[3]);
            $("#gran_total").val(array[4]);
            $("#total_nc2").val(array[5]);
            var total_diferencia = $("#gran_total").val() - $("#total_remision").val();
            $("#diferencia").val(total_diferencia);
          }
        });
      }
    };
    $("#btnFinalizar").click(function() {
      if ($("#escaneada").val() == "") {
        alertify.error("Selecciona una opción");
      } else {
        var ficha_entrada = $("#ficha_entrada").val();
        var clave_proveedor = $("#clave_proveedor").val();
        var nombre_proveedor = $("#nombre_proveedor").val();
        var remision = $("#remision").val();
        var total_remision = $("#total_remision").val();
        var total_entrada = $("#total_entrada").val();
        var total_devoluciones = $("#total_devoluciones").val();
        var total_cf = $("#total_cf").val();
        var total_dc = $("#total_nc").val();
        var total_dc2 = $("#total_nc2").val();
        var gran_total = $("#gran_total").val();
        var diferencia = $("#diferencia").val();
        var escaneada = $("#escaneada").val();
        var url = "insertar_conciliacion.php";
        $.ajax({
          type: "POST",
          url: url,
          data: {
            ficha_entrada: ficha_entrada,
            clave_proveedor: clave_proveedor,
            nombre_proveedor: nombre_proveedor,
            remision: remision,
            total_remision: total_remision,
            total_entrada: total_entrada,
            total_devoluciones: total_devoluciones,
            total_cf: total_cf,
            total_dc: total_dc,
            total_dc2: total_dc2,
            gran_total: gran_total,
            diferencia: diferencia,
            escaneada: escaneada
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "ok") {
              $("#form-datos")[0].reset();
              alertify.success("Registro insertado correctamente");
              $("#ficha_entrada").focus();
              tabla_folios();
              tabla_nc();
              tabla_cf();
            } else if (respuesta == "existe") {
              alertify.error("El registro ya existe");
            }
          }
        });
      }
    });

    function eliminar(id_folio) {
      var url = "eliminar_folio.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id_folio: id_folio
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          alertify.success("El movimiento ha sido eliminado");
          tabla_folios();
        }
      });
    }
  </script>
</body>

</html>