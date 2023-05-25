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
            <h3 class="box-title">Auditoría Piso de Venta | Lista de registros</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <form action="" method="POST" id="frm-libera">
                    <input type="hidden" id="folio" name="folio">
                    <table id='lista_registros' class='table table-striped table-bordered' cellspacing='0' width='192%'>
                      <thead>
                        <tr>
                          <th width='2%'></th>
                          <th width='5%'>Codigo</th>
                          <th>Descripcion</th>
                          <th width='4%'>U. Entrada</th>
                          <th width='4%'>T. Mov</th>
                          <th width='4%'>Folio</th>
                          <th width='4%'>Compra</th>
                          <th>Proveedor</th>
                          <th width='9%'>Depto.</th>
                          <th width='9%'>Fam.</th>
                          <th width='4%'>U. C.</th>
                          <th width='4%'>U. Emp.</th>
                          <th width='4%'>Ventas</th>
                          <th width='4%'>% Falt</th>
                          <th width='4%'>Teórico</th>
                          <th width='4%'>Faltante</th>
                          <th width='4%'>F. Cajas</th>
                          <th width='4%'>Dias Inv.</th>
                          <th width='4%'>Meses Inv.</th>
                          <th width='4%'>Termina</th>
                          <th>Comentario</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>

                        </tr>
                      </tfoot>
                    </table>
                  </form>
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
    <?php include 'modal_comentario.php'; ?>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

  <!-- Page script -->
  <script>
    $(document).ready(function(e) {
      cargar_tabla();
      $('#modal-default').on('show.bs.modal', function(e) {
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
            $('#id_codigo').val(id);
            $('#observacion').val(array[0]);

          }
        });
      });
    });
    $("#btn-comentario").click(function() {
      var url = "actualiza_comentario.php";
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: $('#form-comentario').serialize(),
          success: function(respuesta) {
            $('#modal-default').modal('hide');
            cargar_tabla();
          },
          error: function(xhr, status) {
            alert("error");
            //alert(xhr);
          },
        })
        $('#form-comentario')[0].reset();
        return false;

    });

    function limpiar_tabla() {
      Swal.fire({
        title: 'Estás seguro?',
        text: "Los códigos que no pertenezcan a un folio, serán borrados permanentemente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borra todo!',
        cancelmButtonText: 'Cancelar'
      }).then((result) => {
        if (result.value) {
          var url = "limpiar_registros.php";
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {},
            success: function(respuesta) {
              Swal.fire(
                'Borrado!',
                'Los códigos han sido borrados permanentemente',
                'success'
              )
              cargar_tabla();
            },
            error: function(xhr, status) {
              alert("error");
            }
          });
        }
      })
    }

    function cargar_tabla() {
      $('#lista_registros thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_registros').dataTable().fnDestroy();
      var table = $('#lista_registros').DataTable({
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
            text: 'Foliar Seleccionados',
            className: 'red',
            action: function() {
              libera_multiple();
            },
            counter: 1
          },
          {
            text: 'Limpiar tabla',
            className: 'red',
            action: function() {
              limpiar_tabla();
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_registros.php",
          "dataSrc": "",
          "data": ""
        },
        "columns": [{
            "data": "no"
          },
          {
            "data": "codigo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "ultima_entrada"
          },
          {
            "data": "tipo_mov"
          },
          {
            "data": "folio_mov"
          },
          {
            "data": "cantidad_mov"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "departamento"
          },
          {
            "data": "familia"
          },
          {
            "data": "ultimo_costo"
          },
          {
            "data": "unidad_empaque"
          },
          {
            "data": "ventas"
          },
          {
            "data": "porcentaje"
          },
          {
            "data": "teorico"
          },
          {
            "data": "faltante"
          },
          {
            "data": "faltante_cajas"
          },
          {
            "data": "dias_inv"
          },
          {
            "data": "meses_inv"
          },
          {
            "data": "fecha_termina"
          },
          {
            "data": "comentario"
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

    function libera_multiple() {
      var url = "libera_multiple.php"; // El script a dónde se realizará la petición.
      var liberar = $('input[name=liberar]');
      (async () => {

        const {
          value: folioDesc
        } = await Swal.fire({
          title: 'Ingresa una descripción',
          input: 'text',
          showCancelButton: true,
          inputValidator: (value) => {
            if (!value) {
              return 'Favor de ingresar descripción'
            }
          }
        })

        if (folioDesc) {
          $("#folio").val(folioDesc);
          //Aqui hacemos el post
          $.ajax({
            type: "POST",
            url: url,
            data: $("#frm-libera").serialize(), // Adjuntar los campos del formulario enviado.
            success: function(respuesta) {
              Swal.fire(`Folio ${folioDesc} creado correctamente`);
              cargar_tabla();
            }
          });
        }
        return false;
      })()
      // Evitar ejecutar el submit del formulario.
    }
  </script>
</body>

</html>