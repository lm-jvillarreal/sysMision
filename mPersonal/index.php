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
            <h3 class="box-title">Registro de Personal</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nombre">*Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresa un nombre">
                    <input type="hidden" id="ide_persona" name="ide_persona">
                    <input type="hidden" id="ide_usuario" name="ide_usuario">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="ap_paterno">*Ap. Paterno</label>
                    <input type="text" name="ap_paterno" id="ap_paterno" class="form-control" placeholder="Ingresa un apellido">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="ap_materno">*Ap. Materno</label>
                    <input type="text" name="ap_materno" id="ap_materno" class="form-control" placeholder="Ingresa un apellido">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="id_sucursal">*Sucursal</label>
                    <select name="id_sucursal" id="id_sucursal" class="form-control">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="id_perfil">*Perfil de Usuario</label>
                    <select name="id_perfil" id="id_perfil" class="form-control">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
          </div>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
          </div>
          </form>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Categorías Existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_modulos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Nombre Completo</th>
                        <th width='10%'>Sucursal</th>
                        <th width="10%">Usuario</th>
                        <th width="20%">Usuario</th>
                        <th width="15%">Perfil</th>
                        <th width="10%">Pswd</th>
                        <th width="5%">Activo</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>Sucursal</th>
                        <th>Usuario</th>
                        <th>Usuario</th>
                        <th>Perfil</th>
                        <th>Pswd</th>
                        <th>Activo</th>
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
  <script src="https://cdn.datatables.net/searchpanes/1.2.1/js/dataTables.searchPanes.min.js"></script>
  <script src="https://cdn.datatables.net/select/1.3.2/js/dataTables.select.min.js"></script>

  <!-- Page script -->
  <script>
    $(document).ready(function() {
      cargar_tabla();
    })
    $('#id_sucursal').select2({
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
    $('#id_perfil').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity,
      ajax: {
        url: "consulta_perfil.php",
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
    $.validator.setDefaults({
      submitHandler: function() {
        var url = "insertar_personal.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "ok") {
              alertify.success("Registro guardado correctamente");
              cargar_tabla();
            } else if (respuesta == "duplicado") {
              alertify.error("El registro ya existe");
            } else {
              alertify.error("Ha ocurrido un error");
            }
            $(":text").val(''); //Limpiar los campos tipo Text
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $(document).ready(function() {
      $("#form_datos").validate({
        rules: {
          nombre: "required",
          ap_paterno: "required",
          ap_materno: "required"
        },
        messages: {
          nombre: "Campo requerido",
          ap_paterno: "Campo requerido",
          ap_materno: "Campo requerido"
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
          // Add the `help-block` class to the error element
          error.addClass("help-block");

          if (element.prop("type") === "checkbox") {
            error.insertAfter(element.parent("label"));
          } else {
            error.insertAfter(element);
          }
        },
        highlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
        }
      });
    });

    function estatus(registro) {
      var id_registro = registro;
      var url = 'cambiar_estatus.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Permiso modificado correctamente");
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function restaurar(registro) {
      var id_registro = registro;
      var url = 'restaurar_pass.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Contraseña restaurada correctamente");
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function editar(registro) {
      var id = registro;
      var url = 'consulta_datos_editar.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id: id
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#ide_persona").val(array[0]);
          $("#ide_usuario").val(array[7]);
          $("#nombre").val(array[1]);
          $("#ap_paterno").val(array[2]);
          $("#ap_materno").val(array[3]);
          $("#id_perfil").select2("trigger", "select", {
            data: {
              id: array[8],
              text: array[5]
            }
          });
          $("#id_sucursal").select2("trigger", "select", {
            data: {
              id: array[9],
              text: array[10]
            }
          });
        },
      });
    }

    function cargar_tabla() {
      $('#lista_modulos').dataTable().fnDestroy();
      $('#lista_modulos').DataTable({
        
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        dom: 'Bfrtip',
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
          "url": "tabla_categorias.php",
          "dataSrc": "",
          "data": ""
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "persona"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "user"
          },
          {
            "data": "usuario"
          },
          {
            "data": "perfil"
          },
          {
            "data": "pass"
          },
          {
            "data": "activo"
          }
        ],
        columnDefs: [{
          searchPanes: {
            show: true,
          },
          targets: [2, 5]
        }]
      });
    }

    function cambia_usuario(id_usuario) {
      var url = "nombre_usuario.php";
      var usuario = $("#usr_" + id_usuario).val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          usuario: usuario,
          id_usuario: id_usuario
        },
        success: function(respuesta) {
          alertify.success("El nombre de usuario ha sido actualizado correctamente");
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      cargar_tabla();
      return false;
    }
  </script>
</body>

</html>