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
            <h3 class="box-title">Personal de Vigilancia | Registro</h3>
          </div>
          <div class="box-body">
            <form action="" id="form_datos">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="ap_paterno">*Ap. Paterno:</label>
                    <input type="hidden" name="id" id="id">
                    <input type="text" name="ap_paterno" id="ap_paterno"" class=" form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="ap_materno">*Ap. Materno:</label>
                    <input type="text" name="ap_materno" id="ap_materno" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="nombre">*Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="sucursal">*Sucursal:</label>
                    <select name="sucursal" id="sucursal" class="form-control">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Guardar Registro</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Personal de Vigilancia | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_vigilantes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <td><strong>#</strong></td>
                        <td><strong>Vigilante</strong></td>
                        <td><strong>Sucursal</strong></td>
                        <td><strong></strong></td>
                      </tr>
                      <tr>
                        <th width='5%'>#</th>
                        <th>Vigilante</th>
                        <th width="20%">Sucursal</th>
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
    $(document).ready(function() {
      tabla_vigilantes();
    })
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity,
      ajax: {
        url: "consulta_sucursal.php",
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
    $("#btn-guardar").click(function() {
      if ($("#ap_paterno").val() == "" || $("#ap_materno").val() == "" || $("#nombre").val() == "" || $("#sucursal").val() == "") {
        alertify.error("Favor de rellenar todos los campos");
      } else {
        if($("#id").val()==""){
          var url = "insertar_vigilante.php";
          $msg="Registro insertado correctamente";
        }else{
          var url = "actualizar_vigilante.php";
          $msg="Registro actualizado correctamente";
        }
        var id = $("#id").val();
        var ap_paterno = $("#ap_paterno").val();
        var ap_materno = $("#ap_materno").val();
        var nombre = $("#nombre").val();
        var sucursal = $("#sucursal").val();
        $.ajax({
          type: "POST",
          url: url,
          data: {
            id: id,
            ap_paterno: ap_paterno,
            ap_materno: ap_materno,
            nombre: nombre,
            sucursal: sucursal
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "ok") {
              alertify.success($msg);
              $("#form_datos")[0].reset();
              $("#sucursal").val("").trigger('change.select2');
            }
          }
        });
        tabla_vigilantes();
      }
      return false;
    });

    function tabla_vigilantes() {
      $('#lista_vigilantes thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_vigilantes').dataTable().fnDestroy();
      var table = $('#lista_vigilantes').DataTable({
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
          }
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_vigilantes.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "vigilante"
          },
          {
            "data": "sucursal"
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

    function editar(id) {
      var url = "consultar_vigilante.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#id").val(array[0]);
          $("#ap_paterno").val(array[1]);
          $("#ap_materno").val(array[2]);
          $("#nombre").val(array[3]);
        }
      });
    }
  </script>
</body>

</html>