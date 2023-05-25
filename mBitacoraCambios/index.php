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
        <form method="POST" id="form-cambios">
          <div class="box box-danger" <?php echo $solo_lectura ?>>
            <div class="box-header">
              <h3 class="box-title">Control de Artículos | Bitácora Cambios y Ofertas</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for='tipo'>*Tipo</label>
                    <select name="tipo" id="tipo" class="form-control">
                      <option value="" selected='true' disabled></option>
                      <option value="C">Cambio</option>
                      <option value="O">Oferta</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for='folio'>*Folio</label>
                    <input type="text" name="folio" id="folio" class="form-control">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="descripcion">*Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" readonly='true'>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="fecha">*Vigencia</label>
                    <input type="text" name="fecha_mov" id="fecha_mov" class="form-control" readonly='true'>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="encargado">*Encargado</label>
                    <select name="encargado" id="encargado" class="form-control">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="auxiliar">*Auxiliar</label>
                    <input type="text" name="auxiliar" id="auxiliar" class="form-control">
                  </div>
                </div>
                <dv class="col-md-3">
                  <div class="form-group">
                    <label for="no_aplica">*No aplica:</label>
                    <select name="no_aplica" id="no_aplica" class="form-control">
                      <option value=""></option>
                      <option value="No aplica en sucursal">No aplica en sucursal</option>
                      <option value="No hay existencia">No hay existencia</option>
                      <option value="Complemento">Complemento</option>
                    </select>
                  </div>
                </dv>
              </div>
            </div>
            <div class="box-footer text-right">
              <button class="btn btn-warning" id="btn-guardar">Guardar Registro</button>
            </div>
          </div>
        </form>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Bitácora de Cambios | Listado</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_cambios" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size: 0.9em;">
                    <thead>
                      <tr>
                        <td width="5%"><strong>#</strong></td>
                        <td width="5%"><strong>Tipo</strong></td>
                        <td><strong>Descripcion</strong></td>
                        <td width='5%'><strong>Suc.</strong></td>
                        <td width="8%"><strong>Fecha</strong></td>
                        <td width="17%"><strong>Encargado</strong></td>
                        <td width="15%"><strong>Entregado</strong></td>
                        <td width="25%"><strong>Validar</strong></td>
                      </tr>
                      <tr>
                        <th width="5%"></th>
                        <th width="5%"></th>
                        <th></th>
                        <th width='5%'></th>
                        <th width="8%"></th>
                        <th width="17%"></th>
                        <th width="15%"></th>
                        <th width="25%"></th>
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
    <?php include 'modal_comentario.php'; ?>
    <?php include 'modal_entregado.php'; ?>
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
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script>
    $(document).ready(function() {
      cargar_tabla();
    })

    function cargar_tabla() {
      $('#lista_cambios thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_cambios').dataTable().fnDestroy();
      var table = $('#lista_cambios').DataTable({
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
            title: 'Cambios-Lista',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'Cambios-Lista',
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
          "url": "tabla_cambios.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "tipo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "fecha_movimiento"
          },
          {
            "data": "encargado"
          },
          {
            "data": "entregado"
          },
          {
            "data": "validar"
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
    }
    $('#tipo').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });
    $('#no_aplica').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    });
    $('#encargado').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_encargados.php",
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
    $("#folio").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        var url = "consulta_folio.php"; // El script a dónde se realizará la petición.
        var folio = $("#folio").val();
        var tipo_mov = $("#tipo").val();
        $.ajax({
          type: "POST",
          url: url,
          data: {
            folio: folio,
            tipo_mov: tipo_mov
          }, // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            var array = eval(respuesta);
            $('#descripcion').val(array[0]);
            $('#fecha_mov').val(array[1]);
          }
        });
        return false;
      }
    });
    $("#btn-guardar").click(function() {
      if ($("#tipo").val() == "" || $("#folio").val() == "" || $("#descripcion").val() == "" || $("#vigencia").val() == "" || $("#auxiliar").val() == "") {
        swal("Error de Captura", "Favor de rellenar todos los campos", "error");
      } else {
        $.ajax({
          data: $('#form-cambios').serialize(),
          url: 'insertar_oferta.php', //archivo que recibe la peticion
          type: 'POST', //método de envio
          dateType: 'html',
          success: function(response) {
            if (response == "repetido") {
              alertify.error("El registro ya existe");
            } else {
              swal("Registro exitoso", "El movimiento ha sido registrado", "success");
              $(":text").val('');
              $("#no_aplica").val('').trigger("change.select2");
            }
          }
        });
      }
      cargar_tabla();
      return false;
    })

    function libera_gerencia(id_cambio) {
      var url = "validar_cambio.php";
      var folio = $("#folio_" + id_cambio).val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_cambio: id_cambio,
          folio: folio
        },
        success: function(respuesta) {
          if (respuesta == "validado") {
            alertify.success("El registro ha sido liberado y validado correctamente");
          } else if (respuesta == "no_validado") {
            alertify.warning("El registro ha sido liberado sin validar");
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      cargar_tabla();
      return false;
    }
    $("#btn-comentario").click(function() {
      var url = "insertar_comentario.php";
      var coment_cambio = $("#comentario_cambio").val();
      var id_cambio = $("#id_cambio").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          coment_cambio: coment_cambio,
          id_cambio: id_cambio
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("El comentario se registró correctamente");
            $("#lista_cambios").DataTable().ajax.reload();
          } else {
            alertify.error("Existió un error");
          }
          $('#modal-comentario').modal('hide');
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      //$(":text").val('');
      return false;
    });
    $('#modal-comentario').on('show.bs.modal', function(e) {
      var comentario = $(e.relatedTarget).data().coment;
      var id_cambio = $(e.relatedTarget).data().id;
      console.log(comentario);
      $(this).find('#comentario_cambio').val(comentario);
      $(this).find('#id_cambio').val(id_cambio);
    });
    $("#encargado").change(function() {
      var texto = $('select[name="encargado"] option:selected').text();
      $("#auxiliar").val(texto);
    });
    $('#modal-entregado').on('show.bs.modal', function(e) {
      var entregado = $(e.relatedTarget).data().entregado;
      var id_cambio = $(e.relatedTarget).data().id;
      //console.log(comentario);
      $(this).find('#nombre_recibe').val(entregado);
      $(this).find('#ide').val(id_cambio);
    });
    $("#btn-entrega").click(function() {
      var url = "insertar_entregado.php";
      var nombre_recibe = $("#nombre_recibe").val();
      var id_cambio = $("#ide").val();
      //alert(id_cambio);
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          nombre_recibe: nombre_recibe,
          id_cambio: id_cambio
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("El registro se actualizó correctamente");
            $("#lista_cambios").DataTable().ajax.reload();
          } else {
            alertify.error("Existió un error");
          }
          $('#modal-entregado').modal('hide');
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      //$(":text").val('');
      return false;
    });
  </script>
</body>

</html>