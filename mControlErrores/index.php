<?php
//error_reporting(E_ALL ^ E_NOTICE);
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$mes = date("m");
$ano = date("Y");

function _data_last_month_day()
{
  $month = date('m');
  $year = date('Y');
  $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));

  return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
};

/** Actual month first day **/
function _data_first_month_day()
{
  $month = date('m');
  $year = date('Y');
  return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
}

$fecha1 = _data_first_month_day();
$fecha2 =  _data_last_month_day();
?>
<!DOCTYPE html>
<html>


<head>
  <?php include '../head.php'; ?>
  <!-- <script src="funciones.js"></script> -->
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
        <div class=" box box-danger" <?php echo $solo_lectura ?>>
          <div class="box-header">
            <div class="col-lg-12">
              <h3 class="box-title">Control de errores | Registro</h3>
            </div>
          </div>
          <div class="box-body">
            <form action="" method="POST" id="form-datos" <?php echo $solo_lectura ?>>
              <div class="row">
                <div class="col-lg-2">
                  <div class="form-group">
                    <label for="">Tipo de entrada</label>
                    <select name="tipo_mov" id="tipo_mov" class="form-control">
                      <option value=""></option>
                      <option value="ENTSOC" selected>Sin orden de compra</option>
                      <option value="ENTCOC">Con orden de compra</option>
                    </select>
                    <input type="hidden" id="id_rg" name="id_rg">
                  </div>
                </div>
                <div class="col-lg-2">
                  <div class="form-group">
                    <label for="">Folio:</label>
                    <input type="text" name="folio_mov" id="folio_mov" class="form-control">
                  </div>
                </div>
                <div class="col-lg-2">
                  <div class="form-group">
                    <label for="sucursal">Sucursal:</label>
                    <select name="sucursal" id="sucursal" class="form-control">
                      <option value=""></option>
                      <option value="1">Diaz Ordaz</option>
                      <option value="2">Arboledas</option>
                      <option value="3">Villegas</option>
                      <option value="4">Allende</option>
                      <option value="5">La Petaca</option>
                      <option value="99">CEDIS</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group">
                    <label for="nombre_usr">Autoriza:</label>
                    <input type="text" readonly name="nombre_usr" class="form-control" id="nombre_usr">
                    <input type="hidden" id="id_usr" name="id_usr">
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group">
                    <label for="comentarios">Comentarios</label>
                    <select id="comentarios" name="comentarios" class="form-control" style="width: 100%">
                      <option></option>
                    </select>
                    <!-- <textarea name="comentarios" id="comentarios" class="form-control" cols="10" rows="1"></textarea> -->
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-danger" id="btn-insertar" <?php echo $solo_lectura; ?>>Guardar</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Incidencias | Conteo Mensual</h3>
          </div>
          <div class="box-body">
            <?php
            $cadena_cantidad = "SELECT DISTINCT(ctb_usuario), COUNT(id), nombre_usuario FROM me_control_errores where  month(fecha)=$mes AND year(fecha)=$ano GROUP BY nombre_usuario";
            $consulta_cantidad = mysqli_query($conexion, $cadena_cantidad);
            while ($row_cantidad = mysqli_fetch_array($consulta_cantidad)) {
              ?>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                  <span class="info-box-icon"><i class="fa fa-thumbs-o-down"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text"><?php echo $row_cantidad[2] ?></span>
                    <span class="info-box-number"><?php echo $row_cantidad[1] ?></span>

                    <div class="progress">
                      <div class="progress-bar" style="width: 0%" id="barra_progreso"></div>
                    </div>
                    <span class="progress-description">
                      Total de Incidencias capturadas
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Errores | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fecha_inicio">Fecha de inicio:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha1 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha1 ?>" readonly id="fecha_inicio" name="fecha_inicio" onchange="cargar_tabla();">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fecha_fin">Fecha de Fin:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha2 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha2 ?>" readonly id="fecha_fin" name="fecha_fin" onchange="cargar_tabla();">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id='lista_errores' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="10%">Tipo Mov.</th>
                        <th width="10%">Folio</th>
                        <th>Sucursal</th>
                        <th width="12%">Cve. Autoriza</th>
                        <th width="25%">Autoriza</th>
                        <th>Comentarios</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Tipo Mov.</th>
                        <th>Folio</th>
                        <th>Sucursal</th>
                        <th>Cve. Autoriza</th>
                        <th>Autoriza</th>
                        <th>Comentarios</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'modal_comentario.php'; ?>
    <?php include '../footer2.php'; ?>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <!-- <div class="control-sidebar-bg"></div> -->
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
  <script>
    $(document).ready(function(e) {
      $('#tipo_mov').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        minimumResultsForSearch: Infinity
      });
      $('#sucursal').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        minimumResultsForSearch: Infinity
      });
      cargar_tabla();
    });
    $(function () {
      $('#comentarios').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
         url: "combo_comentarios.php",
         type: "post",
         dataType: 'json',
         delay: 250,
         data: function (params) {
          return {
            searchTerm: params.term
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
    function cargar_tabla_comentarios(){
      $('#lista_comentarios').dataTable().fnDestroy();
      $('#lista_comentarios').DataTable({
        'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   true,
        "pageLength" : 5,
        "ajax": {
          "type": "POST",
          "url": "tabla_comentarios.php",
          "dataSrc": "",
          "data":""
        },
        "columns": [
          { "data": "#" },
          { "data": "Nombre" },
          { "data": "Editar" },
          { "data": "Eliminar" }
        ]
      });
    }
    $('#modal-default').on('show.bs.modal', function(e) {
      cargar_tabla_comentarios();
      $('#form_datos_comentario')[0].reset();
    });
    function guardar(){
      var comentario = $('#comentario').val();
      var id_registro_modal = $('#id_registro_modal').val();
      $.trim(comentario);
      if(comentario == ""){
        alertify.error("Verifica Campos");
      }else{
        $.ajax({
          url: 'insertar_comentario.php',
          type: "POST",
          dateType: "html",
          data: {'comentario':comentario,'id_registro_modal':id_registro_modal},
          success: function(respuesta) {
            if (respuesta == "ok") {
              alertify.success("Registro Guardado Correctamente");
              $('#form_datos_comentario')[0].reset();
              $('#comentario').focus();
              cargar_tabla_comentarios();
            } else if (respuesta == "duplicado") {
              alertify.error("Registro Duplicado");
            }
          },
          error: function(xhr, status) {
            alert("error");
            alert(xhr);
          },
        })
      }
      return
    }
    function eliminar_comentario(id){
      $.ajax({
        url: 'eliminar_comentario.php',
        type: "POST",
        dateType: "html",
        data: {'id':id},
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Registro Eliminado Correctamente");
            cargar_tabla_comentarios();
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
    }
    function editar_comentario(id){
      $.ajax({
        url: 'editar_comentario.php',
        type: "POST",
        dateType: "html",
        data: {'id':id},
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_registro_modal').val(array[0]);
          $('#comentario').val(array[1]);
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
    }
    function cargar_tabla() {
      var fecha_inicio = $('#fecha_inicio').val();
      var fecha_fin    = $('#fecha_fin').val();

      $('#lista_errores').dataTable().fnDestroy();
      $('#lista_errores').DataTable({
        "bPaginate": false,
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
            title: 'FaltantesComprador',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'CostosCero',
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
          "url": "tabla.php",
          "dataSrc": "",
          "data": {
            'fecha_inicio': fecha_inicio,
            'fecha_fin': fecha_fin
          }
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "tipo_mov"
          },
          {
            "data": "folio_mov"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "ctb_usuario"
          },
          {
            "data": "nombre_usuario"
          },
          {
            "data": "comentarios"
          }
        ]
      });
    }
    function mostrar(numero){
      $('#id_comentario'+numero).toggle();
      // if($('#id_comentario'+numero).hasClass('hidden')){
        // $('#id_comentario'+numero).removeClass('hidden');
          $('#id_comentario'+numero).select2({
          placeholder: 'Seleccione una opcion',
          lenguage: 'es',
          //minimumResultsForSearch: Infinity
          ajax: { 
           url: "combo_comentarios.php",
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
      // }else{
      //   $('#id_comentario'+numero).addClass('hidden');
      // }
    }
    function act_comentario(valor,id){
      $.ajax({
        url: 'act_comentario.php',
        type: "POST",
        dateType: "html",
        data: {'id':id,'valor':valor},
        success: function(respuesta) {
          cargar_tabla();
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
    }
    $("#btn-insertar").click(function() {
      var url = "inserta_error.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $('#form-datos').serialize(),
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("incidencia registrada correctamente");
            location.reload();
          } else if (respuesta == "no") {
            alertify.error("Error! Sin permisos!");
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      })
      cargar_tabla($('#fecha_inicio').val(), $('#fecha_fin').val());
      $(":text").val('');
      $("#comentarios").val('');
      $("#sucursal").val('').trigger('change');
      $("#tipo_mov").val('').trigger('change');
      return false;
    });
    $("#sucursal").change(function() {
      var url = "consulta_datos.php";
      var sucursal = $("#sucursal").val();
      var tipo_mov = $("#tipo_mov").val();
      var folio_mov = $("#folio_mov").val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          folio_mov: folio_mov,
          tipo_mov: tipo_mov,
          sucursal: sucursal
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_usr').val(array[1]);
          $('#nombre_usr').val(array[0]);
          //$("proveedor").val(array[2]);
        }
      });
    });

    function datos_editar(id) {
      var url = "consulta_datos_editar.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#id_rg').val(array[0]);
          $('#folio_mov').val(array[2]);
          $('#nombre_usr').val(array[5]);
          $('#id_usr').val(array[4]);
          $('#tipo_mov').val(array[1]).trigger('change.select2');
          $('#sucursal').val(array[3]).trigger('change.select2');
          $("#comentarios").select2("trigger", "select", {
            data: { id: array[6], text:array[7] }
          });
        }
      });
    };
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
      language: 'es',
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