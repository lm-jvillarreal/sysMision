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
            <h3 class="box-title">Reporte Caja | Registro</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Caja:</label>
                    <select name="id_caja" id="id_caja" style="width: 100%"></select>
                    <input type="text" name="id_registro" id="id_registro" value="0" class="hidden">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>*Equipo:</label>
                    <select name="id_equipo" id="id_equipo" style="width: 100%"></select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>*Descripcion de Falla:</label>
                    <input type="text" name="tipo" id="tipo" class="hidden" value="1">
                    <div class="input-group ">
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-danger tipo">Lista de Fallas</button>
                      </div>
                      <!-- /btn-group -->
                      <div id="divselect">
                        <select name="id_falla" id="id_falla" style="width: 100%"></select>
                      </div>
                      <div id="divinput" style="display: none;">
                      <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion de Falla">
                      </div>
                    </div>
                  </div>
                
                </div>
                <div class="col-md-6">
                  
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
            <h3 class="box-title">Lista de Reportes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_reportes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Caja</th>
                        <th>Equipo</th>
                        <th>Falla</th>
                        <th>Status</th>
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
    $('#id_equipo').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
            url: "combo_equipos.php",
            type: "POST",
            dataType: 'json',
            delay: 250,
            data: function (params) {
              var id_caja = $('#id_caja').val();
                return {
                    searchTerm: params.term, // search term
                    id_caja:id_caja
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
    $('#id_caja').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
            url: "combo_cajas.php",
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
    $('#id_falla').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
            url: "combo_fallas.php",
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
    function cargar_tabla() {
      var id_caja = $('#id_caja').val();
      $('#lista_reportes').dataTable().fnDestroy();
      $('#lista_reportes').DataTable( {
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
          "url": "tabla_reportesf.php",
          "dataSrc": "",
          "data" :{'id_caja':id_caja}
        },
        "columns": [
          { "data": "#", "width":"3%" },
          { "data": "Caja", "width":"10%" },
          { "data": "Equipo"},
          { "data": "Fallo" },
          { "data": "Status", "width":"3%" },
          { "data": "Editar", "width":"3%" },
          { "data": "Eliminar", "width":"3%" }
        ]
      });
    }
    cargar_tabla();
    $.validator.setDefaults( {
      submitHandler: function () {
        $.ajax({
          type: "POST",
          url: 'guardar_reportef.php',
          data: $("#form_datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta)
          {
            if (respuesta=="ok") {
              alertify.success("Registro guardado correctamente");
              $('#form_datos')[0].reset();
              cargar_tabla();
              $("#id_equipo").select2("trigger", "select", {
                data: { id: '', text:'' }
              });
              $("#id_caja").select2("trigger", "select", {
                data: { id: '', text:'' }
              });
              $("#id_falla").select2("trigger", "select", {
                data: { id: '', text:'' }
              });
              $('#descripcion').val("");
              if($(".tipo").hasClass('btn-danger')){
                $('#divinput').show();
                $('#divselect').hide();
                $('.tipo').removeClass('btn-danger');
                $('.tipo').addClass('btn-warning');
                $('.tipo').html('Otro:');
                $('#tipo').val('2');
                $("#id_falla").select2("trigger", "select", {
                  data: { id: '', text:'' }
                });
                $('#descripcion').val("");
                llenar_notificaciones();
              }
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
    $( document ).ready( function () {
      $( "#form_datos" ).validate( {
        rules: {
            id_caja: "required",
            id_equipo: "required"
        },
        messages: {
            id_caja: "Campo requerido",
            id_equipo: "Campo requerido"
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
    function eliminar(id){
      swal({
        title: "¿Está Seguro de Eliminar Reporte?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: 'eliminar_reporte.php',
            data: {'id':id} ,
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
    function editar(id){
      $.ajax({
        url: 'editar.php',
        data: {'id':id},
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_registro').val(id);
          $("#id_caja").select2("trigger", "select", {
            data: { id: array[0], text:array[1] }
          });
          $("#id_equipo").select2("trigger", "select", {
            data: { id: array[2], text:array[3] }
          });
          if(array[6] == 1){
            $('#divinput').hide();
            $('#divselect').show();
            $('.tipo').removeClass('btn-warning');
            $('.tipo').addClass('btn-danger');
            $('.tipo').html('Lista de Fallas');

            $("#id_falla").select2("trigger", "select", {
              data: { id: array[4], text:array[5] }
            });
          }else{
            $('#divinput').show();
            $('#divselect').hide();
            $('.tipo').removeClass('btn-danger');
            $('.tipo').addClass('btn-warning');
            $('.tipo').html('Otro:');
            $("#id_falla").select2("trigger", "select", {
              data: { id: '', text:'' }
            });
            $('#descripcion').val(array[4]);
          }
          $('#tipo').val(array[6]);
        }
      });
    }
    $('.tipo').click(function(){
      if($(this).hasClass('btn-danger')){
        $('#divinput').show();
        $('#divselect').hide();
        $(this).removeClass('btn-danger');
        $(this).addClass('btn-warning');
        $(this).html('Otro:');
        $('#tipo').val('2');
        $("#id_falla").select2("trigger", "select", {
          data: { id: '', text:'' }
        });
        $('#descripcion').val("");
      }else{
        $('#divinput').hide();
        $('#divselect').show();
        $(this).removeClass('btn-warning');
        $(this).addClass('btn-danger');
        $(this).html('Lista de Fallas');
        $('#tipo').val('1');
      }
    });
</script>
</body>
</html>
