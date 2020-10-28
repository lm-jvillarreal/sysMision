<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <link href="../plugins/bootstrap-fileinput-master/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="../plugins/VenoBox-master/venobox/venobox.css" type="text/css" media="screen" />
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
        <div class="box box-danger" <?php echo $solo_lectura; ?>>
          <div class="box-header">
            <h3 class="box-title">Registro de Promotores</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="nombre">*Nombre</label>
                    <input type="number" name="id_registro" id="id_registro" value="0" class="hidden">
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre Persona">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="ap_paterno">*Apellido Paterno</label>
                    <input type="text" id="ap_paterno" name="ap_paterno" class="form-control" placeholder="Apellido Paterno">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="compañia">*Compañia</label>
                    <input type="text" id="compañia" name="compañia" class="form-control" placeholder="Compañia">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="crear_usuario">*Telefono</label>
                    <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Telefono">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">*Frecuencia Visita</label><br>
                    <select name="frecuencia" id="frecuencia" class="form-control">
                      <option value="1">Diaria</option>
                      <option value="2">Semanal</option>
                      <option value="3">Quincenal</option>
                      <option value="4">Mensual</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">*Comprador Encargado</label><br>
                    <select name="comprador" id="comprador" class="form-control">
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">*Proveedor</label><br>
                    <select name="proveedor" id="proveedor" class="form-control">
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">*Uso Celular</label><br>
                    <input type="checkbox" id="celular" name="celular">
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button type="submit" class="btn btn-danger" id="guardar">Guardar</button>
              </div>
            </form>
            <form method="POST" id="form_datos_horario">
              <div class="row" id="form_horario" style="display: none;">
                <input type="number" name="id_promotor_h" id="id_promotor_h" value="0" class="hidden">
                <input type="number" name="id_horario" id="id_horario" value="0" class="hidden">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Selecciona Dia</label>
                    <select class="form-control" id="dia" name="dia" style="width: 100%">
                      <option value=""></option>
                      <option value="1">Lunes</option>
                      <option value="2">Martes</option>
                      <option value="3">Miercoles</option>
                      <option value="4">Jueves</option>
                      <option value="5">Viernes</option>
                      <option value="6">Sabado</option>
                      <option value="7">Domingo</option>
                    </select>
                    <input type="date" id="dia_bd" class="form-control" name="dia_bd">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Sucursal</label>
                    <select class="form-control" id="id_sucursal" name="id_sucursal" style="width: 100%">
                      <option value=""></option>
                      <option value="1">Diaz Ordaz</option>
                      <option value="2">Arboledas</option>
                      <option value="3">Villegas</option>
                      <option value="4">Allende</option>
                      <option value="5">Petaca</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Hora de Inicio</label>
                    <input type="text" name="hora_inicio" id="hora_inicio" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Hora Final</label>
                    <input type="text" name="hora_final" id="hora_final" class="form-control">
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <a class="btn btn-danger" id="guardarH" style="display: none;">Guardar Horario</a>
              </div>
            </form>
            <form method="POST" id="form_datos_actividades">
              <input type="number" name="id_promotor_a" id="id_promotor_a" value="0" class="hidden">
              <input type="number" name="id_actividad" id="id_actividad" value="0" class="hidden">
              <div class="row" id="form_actividades" style="display: none;">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Actividades</label>
                    <input type="text" name="actividad" id="actividad" class="form-control" placeholder="Actividades">
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <a class="btn btn-warning" id="guardarA" style="display: none;">Guardar Actividad</a>
              </div>
            </form>
          </div>
        </div>
        <div class="row" style="display: none;" id="tabla_actividades">
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Lista de Actividades</h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12" id="tabla">
                      <div class="table-responsive">
                        <table id="lista_actividades" class="table table-striped table-bordered" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th width="5%">#</th>
                              <th>Nombre</th>
                              <th>Editar</th>
                              <th>Eliminar</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6" style="display: none;" id="tabla_horario">
              <div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Horario</h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12" id="tabla">
                      <div class="table-responsive">
                        <table id="lista_horario" class="table table-striped table-bordered" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th width="5%">#</th>
                              <th>Dia</th>
                              <th>Sucursal</th>
                              <th>Horario</th>
                              <th>Editar</th>
                              <th>Eliminar</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row" id="tabla_promotores">
          <div class="col-md-12">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Lista de Promotores</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="tabla">
                    <div class="table-responsive">
                      <table id="lista_promotores" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th width="3%">#</th>
                            <th>Promotor</th>
                            <th>Encargado</th>
                            <th>Proveedor</th>
                            <th width="5%">Telefono</th>
                            <th width="5%">Frecuencia</th>
                            <th width="5%">Celular</th>
                            <th width="5%"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
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
    <?php include '../footer2.php';
    include 'modal_subir_imagen.php';
    include 'modal_vacaciones.php';
    include 'modal_editar_calendario.php'; ?>
    <!-- Control Sidebar -->
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <?php include '../footer.php'; ?>

  <script src="../plugins/bootstrap-fileinput-master/js/plugins/piexif.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/js/plugins/sortable.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/js/locales/fr.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/js/locales/es.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/themes/fa/theme.js" type="text/javascript"></script>
  <script src="../plugins/bootstrap-fileinput-master/themes/explorer-fa/theme.js" type="text/javascript"></script>
  <script src='../plugins/VenoBox-master/venobox/venobox.min.js'></script>

  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <!-- Page script -->
  <script>
    $('#hora_inicio').inputmask('99:99');
    $('#hora_final').inputmask('99:99');
  </script>
  <script>
    $(function() {
      $('#dia').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es'
      });
      $('#frecuencia').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es'
      });
      $('#id_sucursal').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es'
      });
      $('#dia_ec').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es'
      });
      $('#sucursal_modal_calendario').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es'
      });
    });
    $('#modal-editar').on('show.bs.modal', function(e) {
      var id_promotor_calendario = $(e.relatedTarget).data().id;
      $('#id_promotor_modal_ec').val(id_promotor_calendario);
    });
    $("#btn-eliminar").click(function() {
      var id_promotor = $('#id_promotor_modal_ec').val();
      var id_sucursal = $('#sucursal_modal_calendario').val();
      var dia = $('#dia_ec').val();
      var url = "eliminar_calendario.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          'id_promotor': id_promotor,
          'id_sucursal': id_sucursal,
          'dia': dia
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          if (array[0] == "ok") {
            alertify.success("Se ha Eliminado " + array[1] + ' Registros', 5);

          } else {
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
      return false;
    });

    function estilo_tablas() {
      $('#lista_promotores').dataTable().fnDestroy();
      $('#lista_promotores').DataTable({
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
            title: 'ListaPromotores',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'ListaPromotores',
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
          "url": "tabla_promotores.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "Nombre"
          },
          {
            "data": "Encargado"
          },
          {
            "data": "Proveedor"
          },
          {
            "data": "Telefono"
          },
          {
            "data": "Frecuencia"
          },
          {
            "data": "Celular"
          },
          {
            "data": "Acciones"
          },
        ]
      });
    }

    function estilo_tablas1(id_promotor) {
      $('#lista_actividades').dataTable().fnDestroy();
      $('#lista_actividades').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": true,
        "pageLength": 4,
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
            title: 'ListaActividades',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'ListaActividades',
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
          "url": "tabla_actividades_promotor2.php",
          "dataSrc": "",
          "data": {
            'id_promotor': id_promotor
          },
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "Actividad"
          },
          {
            "data": "Editar"
          },
          {
            "data": "Eliminar"
          },
        ]
      });
    }

    function estilo_tablas2(id_promotor) {
      $('#lista_horario').dataTable().fnDestroy();
      $('#lista_horario').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": true,
        "pageLength": 4,
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
            title: 'ListaHorario',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'ListaHorario',
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
          "url": "tabla_horario.php",
          "dataSrc": "",
          "data": {
            'id_promotor': id_promotor
          },
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "Dia"
          },
          {
            "data": "Sucursal"
          },
          {
            "data": "Horario"
          },
          {
            "data": "Editar"
          },
          {
            "data": "Eliminar"
          },
        ]
      });
    }
    $(function() {
      estilo_tablas();
    })
    $.validator.setDefaults({
      submitHandler: function() {
        var url = "insertar_promotor.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            var array = eval(respuesta);

            if (array[0] == "ok") {
              alertify.success("Registro guardado correctamente");
              if (array[1] == 1) {
                $("#form_datos")[0].reset();
                estilo_tablas();
                $('#form_horario').hide();
                $('#guardarH').hide();
                $('#form_actividades').hide();
                $('#guardarA').hide();
                $('#tabla_horario').hide();
                $('#tabla_actividades').hide();
                $("#proveedor").select2("trigger", "select", {
                  data: {
                    id: '',
                    text: ''
                  }
                });
                $("#comprador").select2("trigger", "select", {
                  data: {
                    id: '',
                    text: ''
                  }
                });
              } else {
                $('#form_actividades').show();
                $('#guardarA').show();
                $('#form_horario').show();
                $('#guardarH').show();

                $('#nombre').attr('readonly', 'readonly');
                $('#ap_paterno').attr('readonly', 'readonly');
                $('#compañia').attr('readonly', 'readonly');
                $('#telefono').attr('readonly', 'readonly');
                $('#id_promotor_h').val(array[1]);
                $('#id_promotor_a').val(array[1]);
                estilo_tablas1(array[1]);
                estilo_tablas2(array[1]);
                estilo_tablas();
                // $('#tabla_promotores').hide();
                $('#guardar').hide();

                $('#tabla_actividades').show();
                $('#tabla_horario').show();
              }

            } else if (array[0] == "duplicado") {
              alertify.error("El registro ya existe");
            } else {
              alertify.error("Ha ocurrido un error");
            }
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
          compañia: "required",
          telefono: "required",
          ap_paterno: "required",
          frecuencia: "required",
          comprador: "required",
          proveedor: "required"
        },
        messages: {
          nombre: "Campo requerido",
          compañia: "Campo requerido",
          telefono: "Campo requerido",
          ap_paterno: "Campo requerido",
          frecuencia: "Campo requerido",
          comprador: "Campo requerido",
          proveedor: "Campo requerido"
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
          $(element).parents(".col-md-3").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
          $(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).parents(".col-md-3").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
          $(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
        }
      });
    });
    $("#guardarH").click(function() {
      var id_promotor = $('#id_promotor_h').val();
      var url = "insertar_horario.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $("#form_datos_horario").serialize(),
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Registro Registrado");
            $("#form_datos_horario")[0].reset();
            $('#id_sucursal').val("").trigger('change.select2');
            $('#dia').val("").trigger('change.select2');
            $('#id_promotor_h').val(id_promotor);
            estilo_tablas2(id_promotor);
            $('#dia_bd').hide();
            $('#dia').removeAttr('disabled');
          } else if (respuesta == "duplicado") {
            alertify.error("Registro Duplicado");
          } else {
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
      return false;
    });
    $("#guardarA").click(function() {
      var id_promotor = $('#id_promotor_a').val();
      var url = "insertar_actividad.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $("#form_datos_actividades").serialize(),
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Registro Registrado");
            $("#form_datos_actividades")[0].reset();
            $('#id_promotor_a').val(id_promotor);
            estilo_tablas1(id_promotor);
          } else if (respuesta == "duplicado") {
            alertify.error("Registro Duplicado");
          } else {
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
      return false;
    });
  </script>
  <script>
    function editar_registro(id_promotor) {
      $("#proveedor").select2("trigger", "select", {
        data: {
          id: '',
          text: ''
        }
      });
      $("#comprador").select2("trigger", "select", {
        data: {
          id: '',
          text: ''
        }
      });
      $.ajax({
        url: 'editar_registro.php',
        data: '&id_promotor=' + id_promotor,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_promotor_h').val(array[0]);
          $('#id_promotor_a').val(array[0]);
          $('#nombre').val(array[1]);
          $('#nombre').val(array[1]);
          $('#ap_paterno').val(array[2]);
          $('#compañia').val(array[3]);
          $('#telefono').val(array[4]);

          $("#comprador").select2("trigger", "select", {
            data: {
              id: array[7],
              text: array[8]
            }
          });
          $('#frecuencia').val(array[9]).trigger('change.select2');
          if (array[10] == "1") {
            $('#celular').prop("checked", true);
          } else {
            $('#celular').prop("checked", false);
          }
          estilo_tablas1(array[0]);
          estilo_tablas2(array[0]);

          $('#id_registro').val(id_promotor);

          $('#form_horario').show();
          $('#guardarH').show();
          $('#tabla_horario').show();
          $('#tabla_actividades').show();

          $('#form_actividades').show();
          $('#guardarA').show();
        }
      });
    }

    function editar_actividad(id_actividad) {
      $.ajax({
        url: 'editar_actividad.php',
        data: '&id_actividad=' + id_actividad,
        type: "POST",
        success: function(respuesta) {
          $('#actividad').val(respuesta);
          $('#id_actividad').val(id_actividad);
        }
      });
    }

    function editar_horario(id_horario) {
      $.ajax({
        url: 'editar_horario.php',
        data: '&id_horario=' + id_horario,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#dia_bd').show();
          // $('#dia').attr('disabled','disabled');
          $('#dia_bd').val(array[5]);
          $('#id_sucursal').val(array[1]).trigger('change.select2');
          $('#hora_inicio').val(array[3]);
          $('#hora_final').val(array[4]);
          $('#id_horario').val(id_horario);
        }
      });
    }

    function eliminar_actividad(id_actividad) {
      var id_promotor = $('#id_promotor_a').val();
      swal({
          title: "¿Está seguro de eliminar registro?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar_actividad.php',
              data: '&id_actividad=' + id_actividad,
              type: "POST",
              success: function(respuesta) {
                if (respuesta == "ok") {
                  alertify.success("Registro Eliminado");
                  estilo_tablas1(id_promotor);
                } else {
                  alertify.error("Ha Ocurrido un Error");
                }
              }
            });
          }
        });
    }

    function eliminar_horario(id_horario) {
      var id_promotor = $('#id_promotor_h').val();
      swal({
          title: "¿Está seguro de eliminar registro?",
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar_horario.php',
              data: '&id_horario=' + id_horario,
              type: "POST",
              success: function(respuesta) {
                if (respuesta == "ok") {
                  alertify.success("Registro Eliminado");
                  estilo_tablas2(id_promotor);
                } else {
                  alertify.error("Ha Ocurrido un Error");
                }
              }
            });
          }
        });
    }

    function eliminar(id, valor) {
      var texto = "";
      if (valor == 1) {
        texto = "¿Desea Activar Promotor?";
      } else if (valor == 2) {
        texto = "Vacaciones Promotor";
      } else if (valor == 3) {
        texto = "Incapacidad Promotor";
      } else if (valor == 4) {
        texto = "Dar de Baja Promotor";
      }
      swal({
          title: texto,
          icon: "warning",
          buttons: ["No", "Si"],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'eliminar_promotor.php',
              data: {
                'id': id,
                'valor': valor
              },
              type: "POST",
              success: function(respuesta) {
                if (respuesta == "ok") {
                  alertify.success('Estatus Cambiado');
                  estilo_tablas();
                } else {
                  alertify.error('Ha Ocurrido un Error');
                }
              }
            });
          }
        });
    }
    $(function() {
      $('#comprador').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "combos_compradores.php",
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
      $('#proveedor').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "combos_proveedores.php",
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
    });
    $("#image").fileinput({
      theme: 'fa',
      language: 'es',
      showUpload: false,
      showCaption: true,
      showCancel: false,
      showRemove: true,
      browseClass: "btn btn-danger",
      fileType: "jpg",
      allowedFileExtensions: ['jpg'],
      overwriteInitial: false,
      maxFileSize: 1000,
      maxFilesNum: 1
    });
    $(document).ready(function() {
      $(".upload").on('click', function() {
        var formData = new FormData();
        var files = $('#image')[0].files[0];
        var id_promotor = $('#id_promotor_modal_subir').val();
        formData.append('file', files);
        formData.append('id_promotor_modal_subir', id_promotor);
        $.ajax({
          url: 'upload.php',
          type: 'post',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            if (response != 0) {
              $(".card-img-top").attr("src", response);
              $('#image').fileinput('reset').trigger('custom-event');
              alertify.success('La imagen ha sido cargada con exito.');
              $("#modalSubir").modal("hide");
            } else {
              alertify.error('Formato de imagen incorrecto.');
            }
          },
          error: function(xhr, status) {
            alertify.error('Error en proceso');
          },
        });
        return false;
      });
    });

    function abrirModalSubir(id_promotor) {
      $('#id_promotor_modal_subir').val(id_promotor);
      $("#modalSubir").modal("show");
    }
    // $('#rango_vacaciones').daterangepicker({
    //   format: 'YYYY/MM/DD'
    // });
    $('#rango_vacaciones').daterangepicker({
      "autoApply": true
    }, function(start, end, label) {
      console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
      $('#fecha1').val(start.format('YYYY-MM-DD'));
      $('#fecha2').val(end.format('YYYY-MM-DD'));
    });
    $('#modal-vacaciones').on('show.bs.modal', function(e) {
      var id_promotor_vacaciones = $(e.relatedTarget).data().id;
      $('#id_promotor_vacaciones').val(id_promotor_vacaciones);
      var url = "consulta_datos_promotor.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          'id_promotor_vacaciones': id_promotor_vacaciones
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);

          $('#nombre_promotor_vaca').html(array[0]);
        }
      });
    });

    $("#guardar_vaca").click(function() {
      var url = "insertar_vacaciones.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: $("#form_datos_vacaciones").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Registro Guardado Correctamente");
            $('#modal-vacaciones').modal("hide");
            estilo_tablas();
          } else if (respuesta == "duplicado") {
            alertify.error("El registro ya existe");
          } else if (respuesta == "vacio") {
            alertify.error("Verifica Campos");
          } else {
            alertify.error("Ha ocurrido un error");
          }
        }
      });
      return false;
    });
  </script>
</body>

</html>