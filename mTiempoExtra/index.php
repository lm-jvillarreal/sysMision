<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha      = date('Y-m-d');
$nuevafecha = strtotime('+1 day', strtotime($fecha));
$nuevafecha = date('Y-m-d', $nuevafecha);
$hora       = date('h:i:s');
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
              <h3 class="box-title">Registro de Tiempo Extra</h3>
            </div>
            <div class="box-body">
              <form method="POST" id="form_datos">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <input type="hidden" id="idUsr" value="<?php echo $id_usuario ?>">
                      <label for="id_persona">*Nombre:</label>
                      <input type="hidden" name="id_registro" id="id_registro">
                      <select name="id_persona" id="id_persona" class="select2" style="width: 250px" onchange="llenar()">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="departamento">*Departamento:</label>
                      <input type="text" name="departamento" id="departamento" class="form-control" style="width: 250px" readonly>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="sucursal">*Sucursal:</label>
                      <input type="text" name="sucursal" id="sucursal" class="form-control" style="width: 250px" readonly>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>*Fecha/Hora Inicio:</label>
                      <div class="input-group date form_datetime" id='datetimepicker_inicio'>
                        <input type='text' class="form-control" id="fecha_inicio" name="fecha_inicio" onchange="diferencia()" value="<?php echo $fecha ?>" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>*Fecha/Hora Fin:</label>
                      <div class='input-group date form_datetime' id='datetimepicker_fin'>
                        <input type='text' class="form-control" id="fecha_fin" name="fecha_fin" onchange="diferencia()" value="<?php echo $fecha ?>" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="tiempo">*Tiempo:</label>
                      <input type="text" name="tiempo" id="tiempo" class="form-control" style="width: 250px">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="comentario">*Motivo:</label>
                      <select name="motivo" id="motivo" class="form-control" style="width: 250px" onchange="if(this.value=='Otro') {document.getElementById('otro').disabled = false} else {document.getElementById('otro').disabled = true}">
                        <option value=""></option>
                        <option value="Inventario">Inventario</option>
                        <option value="Novillo Gordo">Novillo Gordo</option>
                        <option value="Dia de Muertos">Día de Muertos</option>
                        <option value="Dia de las Madres">Día de las Madres</option>
                        <option value="San Valentin">San Valentín</option>
                        <option value="Dia del Niño">Día del Niño</option>
                        <option value="Rosca de Reyes">Rosca de Reyes</option>
                        <option value="Navideño">Navideño</option>
                        <option value="Falta de Persona">Falta de Persona</option>
                        <option value="Cubrir Descanso">Cubrir Descanso</option>
                        <option value="Velada">Velada</option>
                        <option value="Produccion Extra">Producción Extra</option>
                        <option value="Otro">Otro</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="otro">*Motivo(Otro):</label>
                      <input type="text" name="otro" id="otro" class="form-control" style="width: 220px" placeholder="Especifique motivo" disabled>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="comentario">*Comentario:</label>
                      <input type="text" name="comentario" id="comentario" style="width: 250px" class="form-control" placeholder="Agregue un comentario">
                    </div>
                  </div>
                </div>
                <div class="box-footer text-right">
                  <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
                </div>
              </form>
            </div>
          </div>
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Lista Tiempo Extra</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="lista_extras" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th width="5%"> ID</th>
                          <th width="35%">Empleado</th>
                          <th width="10%">Departamento</th>
                          <th width="10%">Sucursal</th>
                          <th width="15%">Motivo</th>
                          <th width="35%">Autoriza</th>
                          <th width="15%">Tiempo</th>
                          <th width="15%">Comentario</th>
                          <th width="15%">Fecha</th>
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
      <?php include '../footer2.php'; ?>
    <!-- Control Sidebar -->
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
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
    function cargar_tabla() {
      var idUsr = $("#idUsr").val();
      $('#lista_extras').dataTable().fnDestroy();
      $('#lista_extras').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        "order": ["0", "ASC"],
        buttons: [{
            extend: 'pageLength',
            text: 'Registros',
            className: 'btn btn-default'
          },
          {
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'Control Equipos',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Control Equipos',
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
          "url": "tabla_tiempo.php",
          //http://200.1.1.197/SMPruebas/mTiempoExtra/
          "dataSrc": "",
          "data": {
            idUsr: idUsr
          }
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "nombre"
          },
          {
            "data": "departamento"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "motivo"
          },
          {
            "data": "autoriza"
          },
          {
            "data": "tiempo"
          },
          {
            "data": "comentario"
          },
          {
            "data": "fecha"
          }
        ]
      });
    }
    $(function() {
      cargar_tabla();
    })
    $(function() {
      $('#id_persona').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "select_persona.php",
          //http://200.1.1.197/SMPruebas/mTiempoExtra/
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
    $.validator.setDefaults({
      submitHandler: function() {
        var url = "insertar_registro.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            if (respuesta == "ok_nuevo") {
              alertify.success("Registro guardado correctamente");
            } else if (respuesta == "ok_actualizado") {
              alertify.success("Registro actualizado correctamente");
            } else if (respuesta == "duplicado") {
              alertify.error("El registro ya existe");
            } else {
              alertify.error("Ha ocurrido un error");
            }
            $("#form_datos")[0].reset(); //Limpiar los campos tipo Text
            $('#id_persona').val("").trigger('change.select2'); //limpiar campos select
            $('#motivo').val("").trigger('change.select2');
            cargar_tabla();
          }
        });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $(document).ready(function() {
      $("#form_datos").validate({
        rules: {
          id_persona:   "required",
          departamento: "required",
          sucursal:     "required",
          comentario:   "required",
          fecha_inicio: "required",
          fecha_fin:    "required",
          motivo:       "required",
          otro:         "required",
          accion:       "required",

        },
        messages: {
          id_persona:   "Campo requerido",
          departamento: "Campo requerido",
          sucursal:     "Campo requerido",
          comentario:   "Campo Requerido",
          fecha_inicio: "Campo Requerido",
          fecha_fin:    "Campo Requerido",
          motivo:       "Campo Requerido",
          otro:         "Campo Requerido",
          accion:        "Campo Requerido",
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
    function editar(id_registro) {
      var url = 'consulta_datos_editar.php';
      //http://200.1.1.197/SMPruebas/mTiempoExtra/
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          id_registro: id_registro
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#id_registro").val(array[0]);
          $("#id_persona").select2("trigger", "select", {
            data: {
              id: array[1],
              text: array[2]
            }
          });
          $("#tiempo").val(array[7]);
          $("#motivo").select2("trigger", "select", {
            data: {
              id: array[8],
              text: array[8]
            }
          });
          $("#incidencia").select2("trigger", "select", {
            data: {
              id: array[4],
              text: array[4]
            }
          });
          $("#comentario").val(array[10]);
          $("#fecha_inicio").val(array[5]);
          $("#fecha_fin").val(array[6]);
        },
      });
    }

    function diferencia() {
      var fecha_inicio = $('#fecha_inicio').val();
      var fecha_fin = $('#fecha_fin').val();

      if (fecha_inicio != "" && fecha_fin != "") {
        var url = 'calcula_diferencia.php';
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: {
            'fecha_inicio': fecha_inicio,
            'fecha_fin': fecha_fin
          },
          success: function(respuesta) {
            $('#tiempo').val(respuesta);
          },
          error: function(xhr, status) {
            alert("error");
            alert(xhr);
          },
        });
      }
    }

    function llenar() {
      var id_persona = $('#id_persona').val();
      var id_registro = $('#id_registro').val();
      if (id_persona != "") {
        var url = 'llenar.php';
        //http://200.1.1.197/SMPruebas/mTiempoExtra/
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: {
            'id_persona': id_persona
          },
          success: function(respuesta) {
            //evaluar el array y separarlo para imprimir por campos
            var array = eval(respuesta)
            $('#departamento').val(array[1]);
            $('#sucursal').val(array[0]);
          },
          error: function(xhr, status) {
            alert("error");
            alert(xhr);
          },
        });
      }
    }
    $('#motivo').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    });
    $('.form_datetime').datetimepicker({
      //language:  'fr',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
      showMeridian: 1
    });
    $('.form_date').datetimepicker({
      language: 'fr',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });
    $('.form_time').datetimepicker({
      language: 'fr',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 1,
      minView: 0,
      maxView: 1,
      forceParse: 0
    });
  </script>
</body>
</html>