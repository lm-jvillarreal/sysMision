<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
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
            <h3 class="box-title">Gastos de aportaciones | Registro</h3>
          </div>
          <div class="box-body">
            <form action="" method="POST" id="form-datos">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="hidden" id="ide_registro" name="ide_registro">
                    <label for="proveedor">*Proveedor</label>
                    <select name="proveedor" id="proveedor" class="form-control">
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="concepto">*Concepto</label>
                    <select name="concepto" id="concepto" class="form-control">
                      <option value=""></option>
                      <option value="GASTO POR ANIVERSARIO" selected="true">GASTO POR ANIVERSARIO</option>
                      <option value="GASTO POR DIA DEL NIÑO">GASTO POR DIA DEL NIÑO</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="total">*Importe</label>
                    <input type="number" name="total" id="total" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="iva">*IVA</label>
                    <input type="number" name="iva" id="iva" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="retencion">*Retención</label>
                    <input type="text" name="retencion" id="retencion" class="form-control" readonly="true" value="0">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="comentarios">*Comentarios</label>
                    <input type="text" name="comentarios" id="comentarios" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>
                      <input type="checkbox" name="si_retenciones" id="si_retenciones" class="minimal-red" value="1">
                      Aplicar retenciones
                    </label>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-insertar">Guardar</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Aportaciones | Lista de aportaciones</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div id="totales"></div><br><br>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_gastos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">Folio</th>
                        <th width="10%">Cve. Prov</th>
                        <th>Proveedor</th>
                        <th>Concepto</th>
                        <th>Comentarios</th>
                        <th>Importe</th>
                        <th width="5%">IVA</th>
                        <th width="5%">Ret.</th>
                        <th width="5%">Total</th>
                        <th width="5%"></th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th width="5%">Folio</th>
                        <th width="10%">Cve. Prov</th>
                        <th>Proveedor</th>
                        <th width="15%">Concepto</th>
                        <th>Comentarios</th>
                        <th>Importe</th>
                        <th width="5%">IVA</th>
                        <th width="5%">Ret.</th>
                        <th width="5%">Total</th>
                        <th width="5%"></th>
                      </tr>
                    </tfoot>
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
    <?php include 'modal_pagos.php'; ?>
    <?php include 'modal_sgral.php'; ?>
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
  <script type="text/javascript">
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);
    $('#concepto').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    })
    $('#proveedor').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_proveedores.php",
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
    var iva;
    var retencion;
    $("#total").keyup(function(event) {
      iva = $("#total").val() * 0.16;
      $("#iva").val(iva.toFixed(2));
      if ($('#si_retenciones').prop('checked')) {
        retencion = ((iva / 3) * 2) + (0.1 * $("#total").val());
        $("#retencion").val(retencion.toFixed(2));
      }
    });
    $('#si_retenciones').click(function() {
      if (this.checked) {
        retencion = ((iva / 3) * 2) + (0.1 * $("#total").val());
        $("#retencion").val(retencion.toFixed(2));
      } else {
        $("#retencion").val(0.00);
      }
    });
    $("#btn-insertar").click(function() {
      var url = "insertar_gasto.php";
      if ($("#proveedor").val() == "" || $("#concepto").val() == "" || $("#total").val() == "" || $("#iva").val() == "" || $("#comentarios").val() == "") {
        alertify.error("Existen campos vacíos, verifica la información");
      } else {
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: $('#form-datos').serialize(),
          success: function(respuesta) {
            if (respuesta == "ok") {
              alertify.success("gasto registrado correctamente");
            } else if (respuesta == "repetido") {
              alertify.error("El folio que intenta registrar ya existe");
            }
            cargar_tabla();
            totales();
          },
          error: function(xhr, status) {
            alert("error");
            //alert(xhr);
          },
        })
        $('#form-datos')[0].reset();
        return false;
      }
    });
    $("#btn-pagar").click(function() {
      var parametros = new FormData($("#form-datos-pago")[0]);
      var url = "insertar_pago.php";
      $.ajax({
        data: parametros,
        url: url,
        type: 'POST', //método de envio
        dateType: 'html',
        contentType: false,
        processData: false,
        success: function(respuesta) {
          $('#modal-default').modal('hide');
        },
        error: function(xhr, status) {
          alert("error");
          $('#modal-default').modal('hide');
          totales();
        },
      })
      cargar_tabla();
      $(":text").val('');
      return false;
    });

    function cargar_tabla() {
      $('#lista_gastos').dataTable().fnDestroy();
      $('#lista_gastos').DataTable({
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
          }
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "cve_proveedor"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "concepto"
          },
          {
            "data": "comentarios"
          },
          {
            "data": "importe"
          },
          {
            "data": "iva"
          },
          {
            "data": "retencion"
          },
          {
            "data": "total"
          },
          {
            "data": "editar"
          }
        ]
      });
    }
    $(document).ready(function() {
      cargar_tabla();
      totales();
      $('#modal-default').on('show.bs.modal', function(e) {
        var id = $(e.relatedTarget).data().id;

        var url = "consulta_datos_modal.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: {
            id: id
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            var array = eval(respuesta);
            $('#id_gasto').val(array[0]);
            $('#fecha_pago').val(array[1]);
            $('#tipo_pago').val(array[2]);
            $('#no_comprobante').val(array[3]);
            $('#observacion').val(array[4]);

          }
        });
      });
      $('#modal-sgral').on('show.bs.modal', function(e) {
        var id = $(e.relatedTarget).data().id;
        //alert(id);
        var url = "tabla_modal.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: {
            ide: id
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            $('#tabla').html(respuesta);
          }
        });
      });
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

    function totales() {
      var url = "consulta_totales.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: "", // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          $('#totales').html(respuesta);
        }
      });
    }

    function editar(id_registro) {
      var url = "datos_editar.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id_registro: id_registro
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#total").val(array[0]);
          $("#iva").val(array[1]);
          $("#retencion").val(array[2]);
          $("#comentarios").val(array[3]);
          $("#ide_registro").val(array[7]);
          var cve_prov = array[4];
          var nombre_prov = array[5];
          $("#proveedor").select2("trigger", "select", {
            data: {
              id: cve_prov,
              text: nombre_prov
            }
          });
        }
      });
    };
  </script>

</body>

</html>