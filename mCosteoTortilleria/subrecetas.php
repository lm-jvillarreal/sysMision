<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <link rel="stylesheet" href="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.css">
</head>

<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <?php include '../header.php'; ?>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <?php include 'menuV2.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Cédula de Costos | Subrecetas</h3>
          </div>
          <form action="" method="POST" id="form-datos">
            <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="clave_subreceta">*Clave:</label>
                    <input type="text" name="clave_subreceta" id="clave_subreceta" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nombre_subreceta">*Nombre:</label>
                    <input type="text" name="nombre_subreceta" id="nombre_subreceta" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="rendimiento">*Rendimiento:</label>
                    <input type="text" name="rendimiento" id="rendimiento" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="unidad_empaque">*U.M.</label>
                    <input type="text" name="unidad_medida" id="unidad_medida" class="form-control">
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="box-footer text-right">
            <button class="btn btn-danger" id="btn-guardar">Guardar Registro</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Cédula de Costos | Lista de subrecetas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id='lista_subrecetas' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                    <thead>
                      <tr>
                        <th width='5%'>#</th>
                        <th width='15%'>Clave</th>
                        <th>Nombre</th>
                        <th width='10%'>Rendimiento</th>
                        <th width='10%'>U.M.</th>
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
    <?php include 'modal_detalle.php'; ?>
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
  <script src="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script>
    $(document).ready(function(e) {
      cargar_tabla();
    });

    function cargar_tabla() {
      $('#lista_subrecetas').dataTable().fnDestroy();
      $('#lista_subrecetas').DataTable({
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
          "url": "tabla_subrecetas.php",
          "dataSrc": "",
          "data": ""
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "clave_receta"
          },
          {
            "data": "nombre_receta"
          },
          {
            "data": "rendimiento"
          },
          {
            "data": "unidad_medida"
          },
          {
            "data": "opciones"
          }
        ]
      });
    }

    function cargar_tabla_modal(id_receta) {
      $('#lista_detalle').dataTable().fnDestroy();
      $('#lista_detalle').DataTable({
        initComplete: function() {
          this.api().columns.adjust();
          var costo_bruto=$("#costo_bruto").val();
          var merma_s = (costo_bruto*0.03).toFixed(2);
          var costo_neto = (parseFloat(costo_bruto)+parseFloat(merma_s)).toFixed(2);
          var rendimiento=$("#rendimiento_modal").val();
          var costo_um=(costo_neto/rendimiento).toFixed(2);
          $("#merma_s").val(merma_s);
          $("#costo_neto").val(costo_neto);
          $("#costo_um").val(costo_um);
        },
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
          "url": "tabla_detalle.php",
          "dataSrc": "",
          "data": {
            id_receta: id_receta
          }
        },
        "columns": [{
            "data": "artc_articulo",
            "width": "5%"
          },
          {
            "data": "artc_descripcion"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "costo_empaque",
            "width": "6%"
          },
          {
            "data": "unidad_medida",
            "width": "5%"
          },
          {
            "data": "factor_empaque",
            "width": "5%"
          },
          {
            "data": "costo_unitario",
            "width": "6%"
          },
          {
            "data": "cantidad_receta",
            "width": "5%"
          },
          {
            "data": "merma",
            "width": "5%"
          },
          {
            "data": "precio_unitario",
            "width": "5%"
          },
          {
            "data": "cambio_estado",
            "width": "5%"
          }
        ],
        "rowCallback": function(row, data, index) {
          $("#costo_bruto").val((parseFloat($("#costo_bruto").val()) + parseFloat(data.precio_unitario)).toFixed(2));
          $("#rendimiento_modal").val((parseFloat($("#rendimiento_modal").val()) + parseFloat(data.cantidad_receta)).toFixed(2))
        }
      });
    }

    function consulta_totales() {
      var costo_bruto=parseFloat($("#costo_bruto").val());
      var merma_s=(parseFloat(costo_bruto)*0.03).toFixed(2);
      var costo_neto=(costo_bruto+merma_s).toFixed(2);
      var rendimiento=parseFloat($("#rendimiento_moda").val());
      var costo_um=(costo_neto/rendimiento).toFixed(2);
      ("#merma_s").val(merma_s);
      $("#costo_neto").val(costo_neto);
      $("#rendimiento_modal").val(rendimiento);
      $("#unimedida").val();
      $("#costo_um").val(costo_um);
    }
    $("#btn-guardar").click(function() {
      if ($("#clave_subreceta").val() == "" || $("#nombre_subreceta").val() == "" || $("#rendimiento").val() == "" || $("#unidad_medida").val() == "") {
        alertify.error("Existen campos vacíos");
      } else {
        var url = "insertar_subreceta.php";
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: $("#form-datos").serialize(),
          success: function(respuesta) {
            if (respuesta == "ok") {
              alertify.success("Subreceta insertada correctamente");
            } else {
              alertify.error("El registro ya existe");
            }
            //$(":text").val("");
            $('#form-datos').trigger("reset");
            $('#form-datos')[0].reset();
            $('#form-datos').get(0).reset();
            $("#artc_articulo").focus();
            cargar_tabla();
          },
          error: function(xhr, status) {
            alert("error");
          }
        });
      }
      //cargar_tabla();
      return false;
    });
    $('#modal-detalle').on('show.bs.modal', function(e) {
      $(".modal-dialog").css("width", "95%");
      var folio = $(e.relatedTarget).data().folio;
      //alert(id);
      var url = "detalle_modal.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio: folio
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#id_receta").val(array[0]);
          $("#clave_receta").val(array[1]);
          $("#receta").val(array[2]);
          $("#unimedida").val(array[3]);
          $("#modal_articulo").focus();
          cargar_tabla_modal(array[0]);
          consulta_totales();
        }
      });
    });
    $("#modal_articulo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_descripcion.php"; // El script a dónde se realizará la petición.
        var artc_articulo = $("#modal_articulo").val();
        //alert(folio);
        $.ajax({
          type: "POST",
          url: url,
          data: {
            artc_articulo: artc_articulo
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "no_existe") {
              $("#modal_articulo").focus();
              swal("el artículo no existe", "", "warning");
            } else {
              var array = eval(respuesta);
              $("#modal_descripcion").val(array[0]);
              $("#modal_subreceta").val(array[1]);
              $("#modal_cantidad").focus();
            }
          }
        });
        return false;
      }
    });
    $("#modal_cantidad").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "insertar_detalle.php"; // El script a dónde se realizará la petición.
        var id_receta = $("#id_receta").val();
        var artc_articulo = $("#modal_articulo").val();
        var artc_cantidad = $("#modal_cantidad").val();
        var subreceta = $("#modal_subreceta").val();
        //alert(folio);
        $.ajax({
          type: "POST",
          url: url,
          data: {
            id_receta: id_receta,
            artc_articulo: artc_articulo,
            artc_cantidad: artc_cantidad,
            subreceta: subreceta
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "ya_existe") {
              $("#modal_articulo").val('');
              $("#modal_cantidad").val('');
              $("#modal_articulo").focus();
              swal("el artículo ya existe", "", "warning");
            } else if (respuesta == "ok") {
              $("#modal_articulo").val('');
              $("#modal_cantidad").val('');
              $("#modal_articulo").focus();
              cargar_tabla_modal(id_receta);
              consultaTotales();
              swal("el artículo ha sido registrado a la receta", "", "success");
            }
          }
        });
        return false;
      }
    });
    $("#modal-detalle").on("hidden.bs.modal", function() {
      $('#form-modal')[0].reset();
    });
    function cambiarEstado(codigo, subreceta){
      var id_articulo = codigo;
      var subreceta = subreceta;
      var id_receta = $("#id_receta").val();
          var url = 'cambiar_estatusSubrecetas.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id_articulo: id_articulo,
                    subreceta: subreceta,
                  id_receta: id_receta},
            success: function(respuesta) {
              if (respuesta=="ok") {
                alertify.success("Registro modificado correctamente");
                $('#costo_bruto').val(0);
                $('#rendimiento_modal').val(0);
                cargar_tabla_modal(id_receta);
              }
            },
            error: function(xhr, status) {
                alert("error");
            },
          });
    }
  </script>
</body>
</html>