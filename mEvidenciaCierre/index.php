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
            <h3 class="box-title">Cierre de Departamentos | Lista de Indicadores</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="departamento">*Departamento</label>
                  <select name="departamento" id="departamento" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_indicadores" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Indicador</th>
                        <th width="5%"></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Cargar Archivo</button>
          </div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'modal_fotografia.php'; ?>
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
  <script>
    var camera = document.getElementById('camera');
    var frame = document.getElementById('frame');
    camera.addEventListener('change', function(e) {
      var file = e.target.files[0];
      var formData = new FormData();
      // Do something with the image file.
      frame.src = URL.createObjectURL(file);
      formData.append("file", file);
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "guardar_evidencia.php");
      xhr.send(formData);
      alert("listo");
    });
    $(":file").filestyle('buttonText', 'Seleccionar');
    $(":file").filestyle('size', 'sm');
    $(":file").filestyle('input', true);
    $(":file").filestyle('disabled', false);

    $(document).ready(function() {
      cargar_tabla();
    });

    $('#departamento').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity,
      ajax: {
        url: "consulta_departamento.php",
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

    function cargar_tabla() {
      var departamento = $("#departamento").val();
      $('#lista_indicadores').dataTable().fnDestroy();
      $('#lista_indicadores').DataTable({
        "initComplete": function(settings, json) {

        },
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_indicadores.php",
          "dataSrc": "",
          "data": {
            departamento: departamento
          }
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "indicador"
          },
          {
            "data": "opciones"
          }
        ]
      });
    };

    $("#departamento").change(function() {
      cargar_tabla();
    });;

    $('#modal-fotografia').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data().id;
      $("#folio").val(id);
    });

    $("#btn_evidencia").click(function() {
      $("#form-evidencia").submit();
    });

    $('#form-evidencia').submit(function(e) {
      var data = new FormData(this); //Creamos los datos a enviar con el formulario
      $.ajax({
        url: 'guardar_evidencia.php', //URL destino
        data: data,
        processData: false, //Evitamos que JQuery procese los datos, daría error
        contentType: false, //No especificamos ningún tipo de dato
        type: 'POST',
        success: function(resultado) {
          if (resultado == "ok") {
            $("#modal-fotografia").modal("hide");
            swal("Satisfactorio!!", "La evidencia ha sido guardada correctamente", "success");
          } else if (resultado == "invalido") {
            alertify.error("El archivo que intenta subir no es válido");
          }
        }
      });

      e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
    });
  </script>
</body>

</html>