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
            <h3 class="box-title">Cédula de Costos | Registro</h3>
          </div>
          <form action="" method="POST" id="form-datos">
            <div class="box-body">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="clave_producto">*Clave:</label>
                    <input type="text" name="clave_producto" id="clave_producto" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nombre_producto">*Producto</label>
                    <input type="text" name="nombre_producto" id="nombre_producto" class="form-control" readonly="true">
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
            <h3 class="box-title">Cédula de Costos | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id='lista_cedula' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                    <thead>
                      <tr>
                        <th width='15%'>Clave</th>
                        <th>Nombre</th>
                        <th width='10%'>Costo bruto</th>
                        <th width='10%'>Merma S.</th>
                        <th width='10%'>Costo Neto</th>
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
    <?php include 'modal_detallecedula.php'; ?>
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
      $('#lista_cedula').dataTable().fnDestroy();
      $('#lista_cedula').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        buttons: [{
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
          "url": "tabla_cedulacostos.php",
          "dataSrc": "",
          "data": ""
        },
        "columns": [{
            "data": "artc_articulo"
          },
          {
            "data": "artc_descripcion"
          },
          {
            "data": "costo_bruto"
          },
          {
            "data": "merma"
          },
          {
            "data": "costo_neto"
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
          var costo_bruto=$("#cedula_costobruto").val();
          var merma_s = (costo_bruto*0.03).toFixed(2);
          var costo_neto = (parseFloat(costo_bruto)+parseFloat(merma_s)).toFixed(2);
          $("#cedula_merma").val(merma_s);
          $("#cedula_costoneto").val(costo_neto);
        },
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        buttons: [{
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
          "url": "tabla_detallecedula.php",
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
            "data": "cambiar_estado",
            "width": "5%"
          }
        ],
        "rowCallback": function(row, data, index) {
          $("#cedula_costobruto").val((parseFloat($("#cedula_costobruto").val()) + parseFloat(data.precio_unitario)).toFixed(2));
        }
      });
    }
    $("#btn-guardar").click(function() {
      if ($("#clave_producto").val() == "" || $("#nombre_producto").val()=="") {
        alertify.error("Existen campos vacíos");
      } else {
        var url = "insertar_producto.php";
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: $("#form-datos").serialize(),
          success: function(respuesta) {
            if (respuesta == "ok") {
              alertify.success("Articulo registrado correctamente");
            } else {
              alertify.error("El articulo ya existe");
            }
            //$(":text").val("");
            $('#form-datos').trigger("reset");
            $('#form-datos')[0].reset();
            $('#form-datos').get(0).reset();
            $("#artc_producto").focus();
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
    $('#modal_detallecedula').on('show.bs.modal', function(e) {
      $(".modal-dialog").css("width", "95%");
      var folio = $(e.relatedTarget).data().folio;
      //alert(id);
      var url = "detalle_modalcedula.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio: folio
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#cedula_costobruto").val(0);
          $("#id_producto").val(array[0]);
          $("#modal_claveproducto").val(array[1]);
          $("#modal_descripcionproducto").val(array[2]);
          $("#modal_articulo").focus();
          cargar_tabla_modal(array[0]);
        }
      });
    });
    $("#clave_producto").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "artc_descripcion.php"; // El script a dónde se realizará la petición.
        var artc_articulo = $("#clave_producto").val();
        //alert(folio);
        $.ajax({
          type: "POST",
          url: url,
          data: {
            artc_articulo: artc_articulo
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "no_existe") {
              $("#clave_articulo").focus();
              swal("el artículo no existe", "", "warning");
            } else {
              var array = eval(respuesta);
              $("#nombre_producto").val(array[0]);
            }
          }
        });
        return false;
      }
    });
    $("#modal_articulo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_descripcioncedula.php"; // El script a dónde se realizará la petición.
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
              $("#subreceta").val(array[1]);
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
        var url = "insertar_detallecedula.php"; // El script a dónde se realizará la petición.
        var id_receta = $("#id_producto").val();
        var artc_articulo = $("#modal_articulo").val();
        var artc_cantidad = $("#modal_cantidad").val();
        var subreceta=$("#subreceta").val();
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
              $("#modal_descripcion").val('');
              $("#modal_cantidad").val('');
              $("#modal_articulo").focus();
              swal("el artículo ya existe", "", "warning");
            } else if (respuesta == "ok") {
              $("#modal_articulo").val('');
              $("#modal_descripcion").val('');
              $("#modal_cantidad").val('');
              $("#modal_articulo").focus();
              cargar_tabla_modal(id_receta);
              consulta_totales(id_receta)
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
    function cambiarEstado(codigo, subreceta, ide){
      var id_articulo = codigo;
      var subreceta = subreceta;
      var ide = ide;
      var id_receta = $("#id_producto").val();
          var url = 'cambiar_estatusCedula.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id_articulo: id_articulo,
                    subreceta: subreceta,
                    ide: ide,
                  id_receta: id_receta},
            success: function(respuesta) {
              if (respuesta=="ok") {
                alertify.success("Registro modificado correctamente");
                $('#cedula_costobruto').val(0);
                //$('#rendimiento_modal').val(0);
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