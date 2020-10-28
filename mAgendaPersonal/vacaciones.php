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
            <h3 class="box-title">Control Vacaciones | Cargar Datos</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Nombre de Persona</label>
                    <input type="hidden" name="id_registro" id="id_registro">
                    <select name="id_usuario" id="id_usuario" class="form-control" onchange="abrir()">
                      <option></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Dias Año 2018</label>
                    <input type="text"  readonly name="anterior2017" id="anterior2017" class="form-control" onchange="llenar();">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Dias Año 2019</label>
                    <input type="text" readonly name="anterior2018" id="anterior2018" class="form-control" onchange="llenar();">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Total Dias</label>
                    <input type="text" name="vigente" id="vigente" class="form-control" readonly>
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
              </div>
            </form>
          </div>
        </div>
        <br>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control Vacaciones | Dias Disponibles</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <div id="datos"></div>
          </div>
        </div>
        <br>
        <div class="box box-danger" id="parte2" style="display: none;">
          <div class="box-header">
            <h3 class="box-title">Control Vacaciones | Detalle de Usuario</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <form id="form_datos2" method="POST">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">*Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" readonly>
                    <input type="text" name="id_usuario2" id="id_usuario2" class="form-control hidden">
                    <input type="number" name="id_registro2" id="id_registro2" class="form-control hidden" value="0">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_inicio">Fecha de inicio:</label>
                    <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_inicio" name="fecha_inicio" >
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>  
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_inicio">Fecha de Fin:</label>
                    <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_fin" name="fecha_fin" >
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Comentarios</label>
                    <input type="text" name="comentarios" id="comentarios" class="form-control">
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <a onclick="limpiar()" class="btn btn-danger">Limpiar / Ocultar</a>
                <a class="btn btn-warning" id="guardar" onclick="guardar()">Guardar</a>
              </div>
            </form>
            <br>
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_vacaciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="20%">Fecha Inicio</th>
                        <th width="20%">Fecha Final</th>
                        <th width="20%">Cantidad Dias</th>
                        <th width="20%">Comentario</th>
                        <th width="10%">Editar</th>
                        <th width="10%">Eliminar</th>
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
                      </tr>
                    </tbody>  
                  </table>
                </div>
              </div>
            </div>  
          </div>
        </div>
        <!-- </div> -->
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
    function cargar_tabla(id_usuario){
      $('#lista_vacaciones').dataTable().fnDestroy();
      $('#lista_vacaciones').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
          "paging":   false,
          "dom": 'Bfrtip',
          "buttons": [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ],
        "ajax": {
            "type": "POST",
            "url": "tabla_vacaciones.php",
            "dataSrc": "",
            "data": {'id_usuario':id_usuario},
        },
        "columns": [
            { "data": "#" },
            { "data": "Fecha Inicio" },
            { "data": "Fecha Final" },
            { "data": "Cantidad Dias" },
            { "data": "Comentarios" },
            { "data": "Editar" },
            { "data": "Eliminar" },
        ]
     });
    }
    $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar_datos.php"; // El script a dónde se realizará la petición.
          $.ajax({
            type: "POST",
            url: url,
            data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
            success: function(respuesta)
            {
              if (respuesta=="ok") {
                alertify.success("Registro guardado correctamente");
                $('#form_datos')[0].reset();
                $('#anterior2017').attr('readonly', true);
                $('#anterior2018').attr('readonly', true);
                $("#id_usuario").select2("trigger", "select", {data: { id: '', text:'' } });
                cargar_datos();
              }else if(respuesta=="duplicado"){
                alertify.error("El registro ya existe");
              }else {
                alertify.error("Ha ocurrido un error");
              }
            }
          });
        // Evitar ejecutar el submit del formulario.
        return false;
      }
    });
    $( document ).ready( function () {
      $( "#form_datos" ).validate( {
        rules: {
          id_usuario: "required",
          anterior2017: "required",
          anterior2018: "required",
          vigente: "required"
        },
        messages: {
          id_usuario: "Campo requerido",
          anterior2017: "Campo requerido",
          anterior2018: "Campo requerido",
          vigente: "Campo requerido"
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
    function cargar_datos(){
      $.ajax({
         url: 'datos.php',
         success: function(respuesta) {
          $('#datos').html(respuesta);
        }
      });
    }
    cargar_datos();
    $(function () {
    $('#id_usuario').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
       url: "combo_usuarios2.php",
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
    function llenar(){
      var anterior2017 = $('#anterior2017').val();
      var anterior2018 = $('#anterior2018').val();
      anterior2017 = (anterior2017 == 0)?"0":anterior2017;
      anterior2018 = (anterior2018 == 0)?"0":anterior2018;
      var vigente2019  = parseInt(anterior2017) + parseInt(anterior2018);
      $('#vigente').val(vigente2019);
    }
    function abrir(){
      $('#anterior2017').attr('readonly', false);
      $('#anterior2018').attr('readonly', false);
    }
    function detalles(id_usuario) {
      $('#parte2').show();
      $.ajax({
         url: 'consulta_datos.php',
         type: "POST",
         data:{'id_usuario':id_usuario},
         success: function(respuesta) {
          var array  = eval(respuesta);
          var id     = array[0];
          var nombre = array[1];
          $('#usuario').val(nombre);
          $('#id_usuario2').val(id);
          $("#id_usuario").select2("trigger", "select", {data: { id: array[5], text:nombre} });
          $('#anterior2017').val(array[2]);
          $('#anterior2018').val(array[3]);
          $('#vigente').val(array[4]);
          $('#id_registro').val(array[6]);
          cargar_tabla(id);
        }
      });
    }
    function guardar(){
      var id = $('#id_usuario2').val();
      $.ajax({
        url: 'insertar_vacaciones.php',
        type: "POST",
        data: $("#form_datos2").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta=="ok") {
            alertify.success("Registro guardado correctamente");
            $('#id_registro2').val("0");
            $('#comentarios').val("");
            cargar_tabla(id);    
            cargar_datos();
            var fecha = new Date().toJSON().slice(0,10);
            $('#fecha_fin').val(fecha);
            $('#fecha_inicio').val(fecha);
            $('#id_registro2').val("0");
          }else if(respuesta=="duplicado"){
            alertify.error("El registro ya existe");
          }else if(respuesta=="1"){
            alertify.error("No tienes dias disponibles");
          }else if(respuesta=="2"){
            alertify.error("No tienes dias suficientes");
          }else {
            alertify.error("Ha ocurrido un error");
          }
        }
      });
    }
    function limpiar(){
      var id = 0;
      $('#parte2').hide();
      cargar_tabla(id);
      $('#usuario').val("");
      $('#id_registro').val("0");  
    }
    function editar(folio){
      $.ajax({
        url: 'editar_vacaciones.php',
        type: "POST",
        data: {'folio':folio}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          var array      = eval(respuesta);
          var fechaini   = array[0];
          var fechafin   = array[1];
          var comentario = array[2];
          $('#id_registro2').val(folio);
          $('#fecha_inicio').val(fechaini);
          $('#fecha_fin').val(fechafin);
          $('#comentarios').val(comentario);
        }
      });
    }
    function eliminar(folio){
      var id_usuario = $('#id_usuario2').val();
      swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: 'eliminar_registro.php',
            data: '&folio='+folio ,
            type: "POST",
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success('Registro Eliminado');
                cargar_tabla(id_usuario);    
                cargar_datos();    
              }
              else{
                alertify.error('Ha Ocurrido un Error');
              }
             }
          });
        } else {
          swal("No se ha eliminado el registro.",{
            icon: "error",
          });
        }
      });
    }
    function limpiar_agenda(){
      $.ajax({
        url: 'quitar_eventos.php',
        data: {},
        type: "POST",
        success: function(respuesta) {
          alertify.success(respuesta + ' Registros Eliminados');
          location.reload();
        }
      });
    }
  </script>
  <script type="text/javascript">
    $('.form_datetime').datetimepicker({
      //language:  'fr',
      weekStart: 1,
      todayBtn:  1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
      showMeridian: 1
    });
    $('.form_date').datetimepicker({
      language:  'es',
      weekStart: 1,
      todayBtn:  1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });
    $('.form_time').datetimepicker({
      language:  'fr',
      weekStart: 1,
      todayBtn:  1,
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