<?php
include '../global_seguridad/verificar_sesion.php';
$filtro_rp = ($registros_propios == '1') ? " AND usuarios.id = '$id_usuario'" : "";
$cadenaComprador = "SELECT usuarios.id, usuarios.id_persona, CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno), usuarios.id_perfil
                    FROM usuarios
                    INNER JOIN personas 
                    WHERE usuarios.id_persona = personas.id AND id_perfil = '5'" . $filtro_rp;
$consultaComprador = mysqli_query($conexion, $cadenaComprador);

$cadenaProveedores="SELECT numero_proveedor, proveedor FROM proveedores";
$consultaProveedores = mysqli_query($conexion,$cadenaProveedores);
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
            <h3 class="box-title">Cargos a Fondos | Registro</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <label for="no_nc">Folio de Oferta</label>
                <input type="text" name="folio_oferta" id="folio_oferta" class="form-control">
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="id_comprador">*Comprador</label>
                  <select name="id_comprador" id="id_comprador" class="form-control select2">
                    <option value=""></option>
                    <?php
                    while ($rowComprador = mysqli_fetch_array($consultaComprador)) {
                      echo "<option value='$rowComprador[0]'>$rowComprador[2]</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="proveedor">*Proveedor</label>
                  <select name="proveedor" id="proveedor" class="form-control select2">
                    <option value=""></option>
                    <?php
                    while ($rowProv = mysqli_fetch_array($consultaProveedores)) {
                      echo "<option value='$rowProv[0]'>$rowProv[1]</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="btn-buscar">Detalle de Oferta</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Cargos a Fondos | Detalle de Oferta</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_aportaciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='10%'>Artículo</th>
                        <th>Descripción</th>
                        <th width='12%'>Inicio</th>
                        <th width='12%'>Fin</th>
                        <th width='10%'>Prov.</th>
                        <th width='10%'>Cantidad</th>
                        <th width='5%'></th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>

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

    function cargar_tabla() {
      var folio_oferta = $("#folio_oferta").val();
      var proveedor = $("#proveedor").val();
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
          },
          {
            text: 'Actualizar listas',
            action: function() {
              $('.select2').select2({
                placeholder: 'Seleccione una opcion',
                lenguage: 'es'
              });
            },
            counter: 1
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "detalle_tabla.php",
          "dataSrc": "",
          "data": {
            folio_oferta: folio_oferta,
            proveedor: proveedor
          }
        },
        "columns": [{
            "data": "articulo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "inicio"
          },
          {
            "data": "fin"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "opciones"
          }
        ]
      });
    }
    $(document).ready(function() {
      $('.select2').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es'
      });
      cargar_tabla();
    });
    $("#btn-buscar").click(function() {
      if ($("#folio_oferta") == "") {
        alert("escribe un folio");
      } else {
        cargar_tabla();
        $('.select2').select2({
          placeholder: 'Seleccione una opcion',
          lenguage: 'es'
        });
      }
    });

    function insertar(folio) {
      if ($("#inicio_" + folio).val() == "" || $("#fin_" + folio).val() == "" || $("#tipo_" + folio).val() == "" || $("#cantidad_" + folio).val() == "") {
        alertify.error("Favor de ingresar la información solicitada");
      } else {
        var url = 'insertar_cargo.php';
        var folio_oferta = $("#folio_oferta").val();
        var fecha_inicio = $("#inicio_" + folio).val();
        var fecha_fin = $("#fin_" + folio).val();
        var codigo = $("#codigo_" + folio).val();
        var descripcion = $("#descripcion_" + folio).val();
        var proveedor = $("#proveedor_" + folio).val();
        var cantidad = $("#cantidad_" + folio).val();
        var comprador = $("#id_comprador").val();
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: {
            folio_oferta: folio_oferta,
            fecha_inicio: fecha_inicio,
            fecha_fin: fecha_fin,
            codigo: codigo,
            descripcion: descripcion,
            proveedor: proveedor,
            cantidad: cantidad,
            comprador: comprador
          },
          success: function(respuesta) {
            if (respuesta == "ok") {
              swal("El cargo ha sido registrado correctamente", {
                icon: "success",
              });
            }
          },
          error: function(xhr, status) {
            alert("error");
            //alert(xhr);
          },
        });
      }
    }
  </script>
</body>

</html>