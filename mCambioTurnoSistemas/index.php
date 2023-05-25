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
                <h3 class="box-title">Registro de Modificaciones</h3>
              </div>
              <div class="box-body">
                <form method="POST" id="form_datos">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="id_persona">*Nombre</label>
                        <input type="hidden" name="id_registro" id="id_registro">
                        <select name="id_persona" id="id_persona" class="form-control select2" onchange="llenar()" >
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="departamento">*Departamento</label>
                        <input type="text" name="departamento" id="departamento" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="sucursal">*Sucursal</label>
                        <input type="text" name="sucursal" id="sucursal" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="horarioA">*Turno Actual:</label>
                        <select name="horarioA" id="horarioA" class="form-control select2">
                          <option value=""></option>
                          <option value="Mañana">Mañana</option>
                          <option value="Tarde">Tarde</option>
                          <option value="Quebrado">Quebrado</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                  <div class="col-md-3">
                      <div class="form-group">
                        <label for="horario">*Turno Nuevo:</label>
                        <select name="horario" id="horario" class="form-control select2">
                          <option value=""></option>
                          <option value="Mañana">Mañana</option>
                          <option value="Tarde">Tarde</option>
                          <option value="Quebrado">Quebrado</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>*Fecha/Hora Inicio:</label>
                        <div class='input-group date' id='datetimepicker_inicio'>
                          <input type='text' class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fecha ?>" />
                          <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>*Fecha/Hora Final:</label>
                        <div class='input-group date' id='datetimepicker_final'>
                          <input type='text' class="form-control" id="fecha_final" name="fecha_final" value="<?php echo $fecha ?>" />
                          <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="comentario">*Comentario</label>
                        <textarea id="comentario" class="form-control" name="comentario" placeholder="Agregue un comentario..."></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer text-right">

                    <button type="button" class="btn btn-warning" id="guardar" onclick="campos_llenos();">Guardar</button>
                    <button type="button" class="btn btn-success pull-left"id="eliminar" onclick="limpiar();" style="display:none">Limpiar</button>
                  </div>
                </form>
              </div>
            </div>
                <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Lista de Modificaciones</h3>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table id="lista_modificacion" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th width = ""> ID</th>
                                <th width = "">No. Empleado</th>
                                <th width = "">Suc.</th>
                                <th width = "">Turno Actual</th>
                                <th width = "">Turno Nuevo</th> 
                                <th width = "">Horario Nuevo</th> 
                                <th width = "">Comentario</th>
                                <th width = "">Registra</th>
                                <th width = "">Autorizar</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                              <th width = ""> ID</th>
                                <th width = "">No. Empleado</th>
                                <th width = "">Suc.</th>
                                <th width = "">Turno Actual</th>
                                <th width = "">Turno Nuevo</th> 
                                <th width = "">Horario Nuevo</th> 
                                <th width = "">Comentario</th>
                                <th width = "">Registra</th>
                                <th width = "">Autorizar</th>
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
          <?php include 'modal_firma.php'; ?>
          <?php include 'modal_firma2.php'; ?>
          <?php include 'modal_rechazar.php'; ?>
          <?php include 'modal_pagar.php'; ?>
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
        $('#horario').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    });
    $('#horarioA').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    });
    function cargar_tablaEmpleados(){
      var ide = $('#id_persona').val();
      $('#lista_modificacion').dataTable().fnDestroy();
      $('#lista_modificacion').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
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
          "url": "tabla_modificacion.php",
          "dataSrc": "",
          "data":{ide:ide}
        },
        "columns": [
          { "data": "id" },
          { "data": "nombre" },
          { "data": "sucursal" },
          { "data": "turno_actual" },
          { "data": "turno_nuevo" },
          { "data": "horario"},
          { "data": "comentario" },
          { "data": "registra" },
          { "data": "activo"}
        ]
      });
    }
        function guardar()
        {
          $.ajax({
            url: 'insertar_horario.php',
            type: "POST",
            dateType: "html",
            data: $("#form_datos").serialize(),
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success("Registro insertado correctamente");
                $('#comentario').val('');
                $('#departamento').val('');
                $('#sucursal').val('');
                $('#fecha_final').val('');
                $('#fecha_inicio').val('');
                $('#id_persona').val("").trigger('change.select2'); //limpiar campos select 
                $('#horarioA').val("").trigger('change.select2'); //limpiar campos select 
                $('#horario').val("").trigger('change.select2'); //limpiar campos select 
                cargar_tablaEmpleados();  
              }else if(respuesta == "actualizado")
              {
                alertify.success("Registro modificado correctamente");
                $('#comentario').val('');
                $('#departamento').val('');
                $('#sucursal').val('');
                $('#fecha_final').val('');
                $('#fecha_inicio').val('');
                $('#id_persona').val("").trigger('change.select2'); //limpiar campos select 
                $('#horarioA').val("").trigger('change.select2'); //limpiar campos select 
                $('#horario').val("").trigger('change.select2'); //limpiar campos select 
                cargar_tablaEmpleados();
              }
            },
            error: function(xhr, status) {
              alert("error");
            },
          });
        }
        cargar_tablaEmpleados();
        $(function () {
          $('#id_persona').select2(
            {
              placeholder: 'Seleccione una opcion',
              lenguage: 'es',
              //minimumResultsForSearch: Infinity
              ajax: { 
                url: "select_personaHorario.php",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                  return {
                    searchTerm: params.term // search term
                  };
                },
                processResults: function (response) {
                  return {
                    results: response
                  };
                },
                cache: true
              }
            })
        });
        $( document ).ready( function () {
          $( "#form_datos" ).validate( {
            rules: {
              id_persona:   "required",
              departamento: "required",
	            comentario:   "required",
              sucursal:     "required",
              horario:      "required",
              fecha_inicio: "required",
              fecha_final:  "required",
            },
            messages: {
              id_persona:   "Campo requerido",
              departamento: "Campo requerido",
	            comentario:   "Campo Requerido",
              sucursal:     "Campo Requerido",
              horario:      "Campo Requerido",
              fecha_inicio: "Campo Requerido",
              fecha_final:  "Campo Requerido",
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
              // Add the `help-block` class to the error element
              error.addClass( "help-block" );
                if ( element.prop( "type" ) === "checkbox" ) {
                  error.insertAfter( element.parent( "label" ) );
                } else {
                  error.insertAfter( element );
                }
            },
            highlight: function ( element, errorClass, validClass ) {
              $( element ).parents( ".col-md-3" ).addClass( "has-error" ).removeClass( "has-success" );
              $( element ).parents( ".col-md-4" ).addClass( "has-error" ).removeClass( "has-success" );
              $( element ).parents( ".col-md-6" ).addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function (element, errorClass, validClass) {
              $( element ).parents( ".col-md-3" ).addClass( "has-success" ).removeClass( "has-error" );
              $( element ).parents( ".col-md-4" ).addClass( "has-success" ).removeClass( "has-error" );
              $( element ).parents( ".col-md-6" ).addClass( "has-success" ).removeClass( "has-error" );
            }
          });
        });
      </script>
      <script>
        function autorizar(registro){
          var id_registro = registro;
          var url = 'cambiar_estatusHorario.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id_registro: id_registro},
            success: function(respuesta) {
              if (respuesta=="ok") {
                alertify.success("Cambio de turno Autorizado");
                //$("#modal-pagar").modal("hide");
                cargar_tablaEmpleados();
              }
            },
            error: function(xhr, status) {
              alert("error");
              //alert(xhr);
            },
          });
        }

        function campos_llenos(){
          if($("#id_persona").val()==""||$("#horario").val()==""||$("#horarioA").val()==""||$("#fecha_inicio").val()==""||$("#comentario").val()==""||$("#fecha_final").val()==""){
            alertify.error("Verifique los campos...");
          }else{
            guardar();
          }
        }
        function llenar(){
          var id_persona = $('#id_persona').val();
          var id_registro =$('#id_registro').val();
          if (id_persona != ""){
            var url = 'llenar.php';
            $.ajax({
              url: url,
              type: "POST",
              dateType: "html",
              data: {'id_persona': id_persona},
              success: function(respuesta) {
                //evaluar el array y separarlo para imprimir por campos
                var array = eval(respuesta)
                //campo__14 sucursal array 0
                //campo__15 departamento array 1
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
        function editar(id){
          $('#eliminar').show();
          var url = 'consulta_datos_editarHorario.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {id: id},
            success: function(respuesta) {
              var array = eval(respuesta);
              $("#id_registro").val(array[0]);
              $("#id_persona").select2("trigger", "select", {
                data: { id: array[1], text: array[2] }
              });
              $("#horarioA").select2("trigger", "select", {
                data: { id: array[3], text: array[3] }
              });
              $("#horario").select2("trigger", "select", {
                data: { id: array[4], text: array[4] }
              });
              $("#comentario").val(array[7]);
            },
          });
        }
        function limpiar(){
          var registro = $('#id_registro').val()
          var url = 'eliminar.php';
          $.ajax({
            url: url,
            type: "POST",
            dateType: "html",
            data: {registro: registro},
            success: function(respuesta) {
              $('#comentario').val('');
                $('#departamento').val('');
                $('#sucursal').val('');
                $('#fecha_final').val('');
                $('#fecha_inicio').val('');
                $('#id_persona').val("").trigger('change.select2'); //limpiar campos select 
                $('#horarioA').val("").trigger('change.select2'); //limpiar campos select 
                $('#horario').val("").trigger('change.select2'); //limpiar campos select 
                $('#eliminar').hide();
                alertify.success("Registro Eliminado Correctamente");
                cargar_tablaEmpleados();

            },
          });
        }
        $(function() {
      $('#datetimepicker_inicio').datetimepicker();
      $('#datetimepicker_final').datetimepicker();
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
        $(function() {
      $('.combo').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es'
      })
    })
      </script>
    </body>
  </html>