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
            <h3 class="box-title">Inventarios Especiales | Categorías</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_categorias" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr style="font-weight: bold;">
                        <td width='10%'>#</td>
                        <td>Categoría</td>
                        <td width='10%'>Artículos</td>
                        <td width='5%'></td>
                      </tr>
                      <tr>
                        <th width='10%'>#</th>
                        <th>Categoría</th>
                        <th width='10%'>Artículos</th>
                        <th width='5%'></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Guardar Registro</button>
          </div>
        </div>
        <div class="box box-danger" style="display: none;">
          <div class="box-header">
            <h3 class="box-title">Proveedores | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_proveedores" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <th>Código</th>
                      <th>Descripción</th>
                      <th>Categoría</th>
                      <th>T. Calculado</th>
                      <th>Físico</th>
                      <th>Diferencia</th>
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
    <?php include 'modal_categorias.php'; ?>
    <?php include 'modal_detalle.php'; ?>
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
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);
    $(document).ready(function() {
      tabla_categorias();
    })

    function tabla_categorias() {
      $('#lista_categorias thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_categorias').dataTable().fnDestroy();
      var table = $('#lista_categorias').DataTable({
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
            copyKeys: '',
            copySuccess: {
              _: '%d lignes copiées',
              1: '1 ligne copiée'
            }
          },
          {
            text: 'Agregar categoría',
            action: function() {
              agregar_categoria();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_categorias.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "categoria"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "opciones"
          }
        ]
      });
      table.columns().every(function() {
        var that = this;
        $('input', this.header()).on('keyup change', function() {
          if (that.search() !== this.value) {
            that
              .search(this.value)
              .draw();
          }
        });
      });
    };

    function tabla_detalle(categoria) {
      $('#detalle_categoria').dataTable().fnDestroy();
      $('#detalle_categoria').DataTable({
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
            copyKeys: '',
            copySuccess: {
              _: '%d lignes copiées',
              1: '1 ligne copiée'
            }
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_detalle.php",
          "dataSrc": "",
          data: {
            categoria: categoria
          }
        },
        "columns": [{
            "data": "codigo",
            "width": "25%"
          },
          {
            "data": "descripcion",
            "width": "45%"
          },
          {
            "data": "categoria",
            "width": "20%"
          },
          {
            "data": "opciones",
            "width": "10%"
          }
        ]
      });
    };

    $('#modal-detalle').on('show.bs.modal', function(e) {
      var folio = $(e.relatedTarget).data().categoria;
      var categoria = $(e.relatedTarget).data().cat;
      tabla_detalle(folio);
      $("#categoria").val(categoria);
      $("#folio").val(folio);
    });

    function agregar_categoria() {
      $("#modal-categorias").modal("show");
    }
    $("#btn-categoria").click(function() {
      $("#form-categorias").submit();
    });
    $('#form-categorias').submit(function(e) {
      if ($("#action").val() == "" || $("#nombre_categoria").val() == "") {
        alertify.error("Datos incompletos.");
      } else {
        var data = new FormData(this); //Creamos los datos a enviar con el formulario
        $.ajax({
          url: 'importar_categoria.php', //URL destino
          data: data,
          processData: false, //Evitamos que JQuery procese los datos, daría error
          contentType: false, //No especificamos ningún tipo de dato
          type: 'POST',
          success: function(resultado) {
            if (resultado == "ok") {
              swal("Satisfactorio!", "La importación de la categoría se realizó correctamente.", "success");
            } else if (resultado == "invalido") {
              alertify.error("El archivo que intenta subir no es válido");
            }
            $(":text").val("");
            tabla_categorias();
            $('#modal-categorias').modal('toggle');
          }
        });
      }
      e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
    });
    $("#artc_articulo").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        if ($("#artc_articulo").val() == "") {

        } else {
          var url = "insertar_articulo.php";
          var artc_articulo = $("#artc_articulo").val();
          var folio = $("#folio").val();
          var categoria = $("#categoria").val();
          $.ajax({
            type: "POST",
            url: url,
            data: {
              artc_articulo: artc_articulo,
              folio: folio,
              categoria: categoria
            }, // Adjuntar los campos del formulario enviado.
            success: function(respuesta) {
              $("#artc_articulo").val("");
              if (respuesta == "no_existe") {
                alertify.error("El artículo que intenta agregar, no existe");
              } else if (respuesta == "ya_registrado") {
                alertify.error("El artículo que intenta agregar, ya existe en la categoría");
              } else {
                alertify.success("Artículo agregado correctamente");
                tabla_detalle($("#folio").val());
              }
            }
          });
        }
        return false;
      }
    });

    function eliminar(categoria, articulo) {
      var url = "eliminar_articulo.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          categoria: categoria,
          articulo: articulo
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "ok") {
            tabla_categorias();
            tabla_detalle(categoria);
            alertify.success("Articulo eliminado correctamente");
          }
        }
      });
    }
  </script>
</body>

</html>