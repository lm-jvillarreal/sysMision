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
        <div class="box box-danger" <?php echo $solo_lectura?>>
          <div class="box-header">
            <h3 class="box-title">Catálogo Marcas</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
            <input type="hidden" name="id_registro" id="id_registro" class="form-control">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Marca:</label>
                    <input type="text" name="marca" id="marca" class="form-control" placeholder="Nombre de la marca">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="equipo">*Equipo</label>
                    <select name="equipo" id="equipo" class="form-control select2">
                    </select>
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="box box-danger" id="tabla_marcas">
          <div class="box-header">
            <h3 class="box-title">Marcas | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_marcas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Marca</th>
                        <th>Equipo</th>
                        <th>Modelos</th>
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
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include 'modal2v.php'; ?>
 <?php include '../footer2.php'; ?>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php include '../footer.php';?>
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
      $('#lista_marcas').dataTable().fnDestroy();
      $('#lista_marcas').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
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
          "url": "tabla_marcas2.php",
          "dataSrc": ""
        },
        "columns": [
          { "data": "#", "width":"3%" },
          { "data": "Nombre"},
          { "data": "Equipo"},
          { "data": "Modelos" },
          { "data": "Editar"},
          { "data": "Eliminar"}
        ]
      });
  }
  cargar_tabla();
  $.validator.setDefaults( {
    submitHandler: function () {
      $.ajax({
        type: "POST",
        url: 'insertar_marca2.php',
        data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if (respuesta=="ok") {
            alertify.success("Registro guardado correctamente");
            $('#form_datos')[0].reset();
            $('#equipo').val("").trigger('change.select2'); 
            cargar_tabla();
            // cargar();
          }else if(respuesta=="ok_actualizado"){
            alertify.success("Registro_actualizado");
            $('#form_datos')[0].reset();
            $('#equipo').val("").trigger('change.select2');
            cargar_tabla();
          }else if(respuesta=="duplicado"){
            alertify.error("El registro ya existe");
          }else if(respuesta=="vacio"){
            alertify.error("Verifica Campos");
          }else {
            alertify.error("Ha ocurrido un error");
          }
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }
  });
  function editar_marca(id){
      $.ajax({
        url: 'editar_marca2.php',
        data: '&id='+ id,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_registro').val(array[0]);
          $('#marca').val(array[1]);
          $("#equipo").select2("trigger", "select", {
            data: { id: array[2], text:array[3] }
          });
        }
      });
    }
  $( document ).ready( function () {
    $( "#form_datos" ).validate( {
      rules: {
        no_serie: "required",
        id_sucursal: "required",
        ubicacion: "required",
        marca: "required",
        modelo: "required",
        tipo: "required",
        capacidad: "required",
        entrada_salida: "required",
        tomacorrientes: "required",
        tiempo_respaldo: "required",
        garantia: "required",
        series: "required"
      },
      messages: {
        no_serie: "Campo requerido",
        id_sucursal: "Campo requerido",
        ubicacion: "Campo requerido",
        marca: "Campo requerido",
        modelo: "Campo requerido",
        tipo: "Campo requerido",
        capacidad: "Campo requerido",
        entrada_salida: "Campo requerido",
        tomacorrientes: "Campo requerido",
        tiempo_respaldo: "Campo requerido",
        garantia: "Campo requerido",
        series: "Campo requerido"
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
  function eliminar_marca(id){
      swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: 'eliminar_marca.php',
            data: '&id='+id ,
            type: "POST",
            success: function(respuesta) {
              if(respuesta == "ok"){
                alertify.success('Registro Eliminado');
                cargar_tabla();
              }
              else{
                alertify.error('Ha Ocurrido un Error');
              }
             }
          });
        }
      });
    }
  $(function () {
    $('#equipo').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
        url: "select_tipo.php",
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
  $('#modal-default2').on('show.bs.modal', function(e) {
       var id = $(e.relatedTarget).data().id;
       var url = "consulta_datos_modal2.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: {id:id}, // Adjuntar los campos del formulario enviado.
          success: function(respuesta)
          {
            var array = eval(respuesta);
            $('#id_registro_m').val(array[0]);
            $('#marca_m').val(array[1]);
            $('#id_marca').val(array[0]);
            estilo_tablas_modelos2();
          }
        });
    });
    function estilo_tablas_modelos2(){
        var id_marca = $('#id_marca').val();
      $('#lista_modelos_escaner').dataTable().fnDestroy();
      $('#lista_modelos_escaner').DataTable( {
        'language': {"url": "../plugins/DataTables/Spanish.json"},
          "paging":   false,
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
          "url": "tabla_modelosv2.php",
          "dataSrc": "",
          "data" :{'id_marca':id_marca}
        },
        "columns": [
          { "data": "#","width":"3%" },
          { "data": "Marca" },
          { "data": "Modelo" },
          { "data": "Editar","width":"3%" },
          { "data": "Eliminar","width":"3%" },
        ]
      });
    }
    $("#btn-guardar_modelo").click(function(){

var marca  = $('#marca_m').val();
var modelo = $('#modelo_terminal').val();
var tipo   = $('#tipo_terminal').val();
var mensaje = "";

if(tipo== 1){
  if(marca != "" && modelo != "" && tipo != ""){
    mensaje = "ok";
  }else{
    mensaje = "vacio";
  }
}else{
  if(marca != "" && modelo != ""){
    mensaje = "ok";
  }else{
    mensaje = "vacio";
  }
}
if(mensaje == "ok"){
var url = "insertar_modelo.php";
  $.ajax({
    url: url,
    type: "POST",
    dateType: "html",
    data: $('#form_datos_terminal').serialize(),
    success: function(respuesta) {
      if (respuesta=="ok") {
        alertify.success("Registro guardado Correctamente");
        estilo_tablas_modelos2();
        //$("#form_datos_terminal")[0].reset();
        //$("#marca_m").select2("trigger", "select", {
          //data: { id: '', text:'' }
        //});
        $("#tipo_terminal").select2("trigger", "select", {
          data: { id: '', text:'' }
        });
      }else if(respuesta == "duplicado"){
        alertify.error("Registro Duplicado");
      }else if(respuesta == "ok_actualizado"){
        alertify.success("Registro Actualizado");
        estilo_tablas_modelos2();
        $("#modelo_terminal").val("");
        $("#id_registro_mo").val("");
        //$("#form_datos_terminal")[0].reset();
        //$("#marca_m").select2("trigger", "select", {
          //data: { id: '', text:'' }
        //});
        //$("#tipo_terminal").select2("trigger", "select", {
          //data: { id: '', text:'' }
        //});
      }
      else{
        alertify.error("Ha Ocurrido un Error");
      }
    }
  });
  return false;
}else{
 alertify.error("Verifica Campos",2);
}
});
function editar_modelo(id){
      $.ajax({
        url: 'editar_modelo.php',
        data: '&id='+ id,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_registro_mo').val(array[0]);
          $("#marca_m").val(array[1]);
          $('#modelo_terminal').val(array[2]);
          $("#tipo_terminal").val(array[3]);
        }
      });
    }
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
