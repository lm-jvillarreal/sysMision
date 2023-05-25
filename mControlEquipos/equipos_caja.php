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
            <h3 class="box-title">Equipos por Caja | Registro</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                      <input type="text" name="id_registro" id="id_registro" value="0" class="hidden">
                    <label for="nombre_usuario">*Sucursal:</label>
                    <select name="sucursal" id="sucursal" style="width: 100%"></select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Caja:</label>
                    <select name="caja" id="caja" style="width: 100%"></select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Equipo:</label>
                    <select name="id_equipo" id="id_equipo" style="width: 100%"></select>
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
            <h3 class="box-title">Lista de Equipos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_equipos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Equipo</th>
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

<?php include '../footer.php'; include 'modal_3.php'; ?>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
    $('#sucursal').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
            url: "combo_sucursales.php",
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
    $('#caja').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
            url: "combo_cajas2.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                var id_sucursal = $('#sucursal').val();
                return {
                    searchTerm: params.term, // search term
                    id_sucursal:id_sucursal
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
    $('#id_equipo').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
            url: "combo_equipos.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                var id_sucursal = $('#sucursal').val();
                return {
                    searchTerm: params.term, // search term
                    id_sucursal:id_sucursal
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
        var id_caja = $('#caja').val();
        $('#lista_equipos').dataTable().fnDestroy();
        $('#lista_equipos').DataTable( {
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
            "url": "tabla_equipos_pcaja.php",
            "dataSrc": "",
            "data" :{'id_caja':id_caja}
        },
        "columns": [
            { "data": "#", "width":"3%" },
            { "data": "Nombre" },
            { "data": "Editar", "width":"3%" },
            { "data": "Eliminar", "width":"3%" }
        ]
        });
    }
    //al cambiar el valor de la caja la tabla se actualiza
    $('#caja').change(function(){
      cargar_tabla();
    })
    //al cambiar el valor de la caja la tabla se actualiza

    //funcion del submit para insertar
    $.validator.setDefaults( {
      submitHandler: function () {
        $.ajax({
          type: "POST",
          url: 'guardar_equipo.php',
          data: $("#form_datos").serialize(),
          success: function(respuesta)
          {
            if (respuesta=="ok") {
              alertify.success("Registro guardado correctamente");
              cargar_tabla();
              //se dejan los campos con los valores para que la tabla conserve los filtros.
              // $('#sucursal').val("").trigger('change.select2');
              // $('#caja').val("").trigger('change.select2');
              // $('#id_equipo').val("").trigger('change.select2');
              //$('#form_datos')[0].reset();
            }else if(respuesta=="duplicado"){
              alertify.error("El registro ya existe");
            }else {
              alertify.error("Ha ocurrido un error");
            }
          }
        });
        return false;
      }
    });
    //funcion del submit para insertar

    //validaciones para insertar los datos
    $( document ).ready( function () {
      $( "#form_datos" ).validate( {
        rules: {
            sucursal: "required",
            caja: "required",
            id_equipo: "required"

        },
        messages: {
            sucursal: "Campo requerido",
            caja: "Campo requerido",
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
    //validaciones para insertar los datos

    function eliminar_equipo(id){
      swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: 'eliminar_equipodc.php',
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

    function editar_equipo(id){
      $.ajax({
        url: 'editar_equipodc.php',
        data: {'id':id},
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_registro').val(id);
          $("#id_equipo").select2("trigger", "select", {
            data: { id: array[4], text:array[5] }
          });
        }
      });
    }
    $('#act_var').click(function(){
      $.ajax({
        url: 'actu_multiple.php',
        data: $('#form_datos2').serialize(),
        type: "POST",
        success: function(respuesta) {
          if (respuesta=="ok") {
            alertify.success("Registro guardado correctamente");
            $('#modal-default3').modal('hide');
            cargar_tabla();
          }else if (respuesta == "vacio"){
            alertify.error("Verifica Campos");
          }else{
            alertify.error("Ha ocurrido un error");
          }
        }
      });
    })
</script>
</body>
</html>
