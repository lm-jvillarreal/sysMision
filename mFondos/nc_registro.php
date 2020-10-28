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
      <?php include 'menuV3.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Aportaciones | Registro</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <label for="no_nc">No. de N.C.</label>
                <input type="text" name="no_nc" id="no_nc" class="form-control">
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="btn-buscar">Buscar movimiento</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Aportaciones | Detalle</h3>
          </div>
          <div class="box-body">
            <form action="" method="POST" id="form-datosAp">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="fecha_afectacion">*Fecha</label>
                    <input type="text" name="fecha_afectacion" id="fecha_afectacion" class="form-control" readonly="TRUE">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="movimiento">*Movimiento</label>
                    <input type="text" name="movimiento" id="movimiento" class="form-control" readonly="TRUE">
                  </div>
                </div>
                <div class="col-md-2">
                  <label for="folio">*Folio</label>
                  <input type="text" name="folio" id="folio" class="form-control" readonly="TRUE">
                </div>
                <div class="col-md-2">
                  <label for="valor">*Valor</label>
                  <input type="text" name="valor" id="valor" class="form-control" readonly="TRUE">
                  <input type="hidden" name="val_real" id="val_real">
                </div>
                <div class="col-md-4">
                  <label for="proveedor">*Proveedor</label>
                  <input type="text" name="proveedor" id="proveedor" class="form-control" readonly="true">
                  <input type="hidden" name="cve_prov" id="cve_prov">
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="sucursal">*Sucursal</label>
                    <input type="text" name="sucursal" id="sucursal" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="folio_oferta">*Folio de Oferta</label>
                    <input type="text" id="folio_oferta" name="folio_oferta" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="id_comprador">*Comprador</label>
                    <select name="id_comprador" id="id_comprador" class="form-control">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="comentarios">*Comentarios</label>
                    <input type="text" name="comentarios" id="comentarios" class="form-control">
                    <input type="hidden" name="consecutivo" id="consecutivo">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="btn-insertar">Registrar aportación</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Aportaciones | Lista de aportaciones</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_aportaciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">Mov.</th>
                        <th width="5%">Folio</th>
                        <th width="5%">Fecha</th>
                        <th width="5%">Suc.</th>
                        <th width="5%">Cve.</th>
                        <th>Proveedor</th>
                        <th>Comentarios</th>
                        <th>Comprador</th>
                        <th>Concepto</th>
                        <th width="7%">Valor</th>
                        <th width="5%">Comentarios</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Mov.</th>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Suc.</th>
                        <th>Cve.</th>
                        <th>Proveedor</th>
                        <th>Comentarios</th>
                        <th>Comprador</th>
                        <th>Concepto</th>
                        <th>Valor</th>
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
    <?php include 'escarg_modal.php'; ?>
    <?php include 'nc_modal.php'; ?>
    <?php include 'modal_comentario.php'; ?>
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
    $('#id_comprador').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_compradores.php",
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
    $(document).ready(function(e) {
      $('#modal-comentario').on('show.bs.modal', function(e) {
        var id = $(e.relatedTarget).data().id;

        var url = "consulta_comentario.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: {
            id: id
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            var array = eval(respuesta);
            $('#id_aportacion').val(array[0]);
            $('#area_comentario').text(array[1]);
          }
        });
      });
      $('#modal-escarg').on('show.bs.modal', function(e) {
        var id = $(e.relatedTarget).data().id;
        var mov = $(e.relatedTarget).data().mov;
        var suc = $(e.relatedTarget).data().suc;
        //alert(id);
        var url = "tabla_modal.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: {
            ide: id,
            movi: mov,
            suc: suc
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            $('#tabla').html(respuesta);
          }
        });
      });
      $('#modal-nc').on('show.bs.modal', function(e) {
        var id = $(e.relatedTarget).data().id;
        var consec = $(e.relatedTarget).data().consec;
        //alert(id);
        var url = "nc_modal_contenido.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: {
            id: id,
            consecutivo: consec
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            $('#res').html(respuesta);
          }
        });
      });
      $("#sucursal").select2("trigger", "select", {
        data: {
          id: "<?php echo $id_sede; ?>",
          text: "<?php echo $nombre_sede; ?>"
        }
      });
    });
    $("#btn-buscar").click(function() {
      var url = "nc_consulta.php"; // El script a dónde se realizará la petición.
      var folio_mov = $("#no_nc").val();
      $(":text").val('');
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio_mov: folio_mov
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#fecha_afectacion').val(array[0]);
          $('#movimiento').val(array[1]);
          $('#folio').val(array[2]);
          $('#valor').val(array[3]);
          $('#proveedor').val(array[4]);
          $('#cve_prov').val(array[5]);
          $('#sucursal').val(array[6]);
          $('#val_real').val(array[7]);
          $('#consecutivo').val(array[8]);
        }
      });
      return false;
    });
    $("#btn-insertar").click(function() {
      var url = "nc_insertar.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $('#form-datosAp').serialize(),
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Aportación registrada correctamente");
          } else if (respuesta == "repetido") {
            alertify.error("El folio que intenta registrar ya existe");
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      cargar_tabla();
      $(":text").val('');
      totales();
      return false;
    });
    $("#btn-modifComent").click(function() {
      var url = "editar_comentario.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $('#form-comentario').serialize(),
        success: function(respuesta) {
          $('#modal-comentario').modal('hide');
        },
        error: function(xhr, status) {
          alert("error");
          $('#modal-comentario').modal('hide');
        },
      })
      cargar_tabla();
      return false;
    });

    function cargar_tabla() {
      $('#lista_aportaciones').dataTable().fnDestroy();
      $('#lista_aportaciones').DataTable({
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
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "escarg_tabla.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "tipo_movimiento"
          },
          {
            "data": "folio_movimiento"
          },
          {
            "data": "fecha_afectacion"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "cve_proveedor"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "comentarios"
          },
          {
            "data": "comprador"
          },
          {
            "data": "concepto"
          },
          {
            "data": "valor"
          },
          {
            "data": "editar_comentario"
          }
        ]
      });
    }
    $(document).ready(function() {
      cargar_tabla();
    });
  </script>
</body>

</html>