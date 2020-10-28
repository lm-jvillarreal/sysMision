<?php
  include '../global_seguridad/verificar_sesion.php';
  if($perfil_usuario == 1 || $perfil_usuario == 2 || $id_usuario == 106){
    $acesso  = "";
    $acesso2 = "style='display: none'";
  }else{
    $acesso  = "style='display: none'";
    $acesso2 = "";
  }
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
      <div class="box box-danger" <?php echo $acesso2;?>>
        <div class="box-header">
          <h3 class="box-title">Lista de Promotores Activos</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista_promotores_activos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th>Nombre</th>
                      <th>Compañia</th>
                      <th>Actividad en Proceso</th>
                      <th>Hora Inicio Actividad</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
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
      <div class="box box-danger" <?php echo $acesso;?>>
        <div class="box-header">
          <h3 class="box-title">Editar Visita Promotor</h3>
        </div>
        <div class="box-body">
          <form id="form_datos" method="POST">
            <input type="hidden" id="id_entrada" name="id_entrada" class="form-control">
            <input type="hidden" value="0" id="cajas_e" name="cajas_e">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-4">
                  <label>*Dia</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly name="fecha" id="fecha" onchange="cargar_datos()">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
                <div class="col-md-3">
                  <label>*Promotor</label>
                  <select name="promotor" id="promotor" class="form-control" onchange="cargar_datos()"></select>
                </div>  
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="">*Hora Entrada</label>
                    <input type="text" class="form-control tiempo" name="hora_entrada" id="hora_entrada">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="">*Hora Salida</label>
                    <div id="h_s">
                      <input type="text" class="form-control tiempo" name="hora_salida" id="hora_salida">
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label for="">*Cajas</label>
                    <input type="text" class="form-control" name="cajas" id="cajas" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <button type="button" class="btn btn-warning" onclick="actualizar_prom()">Actualizar</button>
              <button type="button" data-id = '1' data-toggle = 'modal' data-target = '#modal-salida' target='blank' class="btn btn-danger" id="boton_salida" disabled></a>Salida Promotor</button>
              <button type="button" class="btn btn-warning" onclick="eliminar_entrada_promotor()" id="eliminar_entrada">Eliminar Entrada</button>
            </div>
          </form>
        </div>
      </div>
      <div class="box box-danger" <?php echo $acesso;?>>
        <div class="box-header">
          <h3 class="box-title">Lista de Actividades de Promotor</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista_actividades" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th>Actividad</th>
                      <th width="10%">Hora Inicio</th>
                      <th width="10%">Hora Final</th>
                      <th>Comentario</th>
                      <th width="10%">Cajas</th>
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
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include '../footer2.php'; include 'modal_salida.php';?>
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
<script type="text/javascript">
  function eliminar_entrada_promotor() {
    swal({
        title: "¿Está seguro de eliminar entrada del promotor?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
    .then((willDelete) => {
      if (willDelete) {
        var id_promotor = $('#promotor').val();
        $.ajax({
          url: 'eliminar_entrada.php',
          type: "POST",
          dateType: "html",
          data: {'id_promotor':id_promotor},
          success: function(respuesta) {
            if (respuesta=="ok") {
              alertify.success("Entrada Eliminada");
            $("#promotor").select2("trigger", "select", {
              data: { id:'', text:'' }
            });
            }else{
              alertify.error("Ha Ocurrido un Error");
            }
          }
        });
      }
    });
  }
  $('#modal-salida').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data().id;
    $('#razon').val("");
  });
  $("#guardar_modal").click(function(){
    var url = "salida_antes.php";
    var id_promotor = $('#promotor').val();
    var comentario  = $('#razon').val();
    if(id_promotor != null && comentario != ""){
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {'id_promotor':id_promotor,'comentario':comentario},
        success: function(respuesta) {
          if (respuesta=="ok") {
            alertify.success("Salida Autorizada");
            $('#modal-salida').modal('hide');
            cargar_datos();
            estilo_tablas2();
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
    }else{
      alertify.error("Verifica Campos");
      return false;
    }    
    return false;
  });
  function actualizar_prom(){
    $.ajax({
      url: 'actualizar_visita.php',
      data: $('#form_datos').serialize(),
      type: "POST",
      success: function(respuesta) {
        if(respuesta == "ok"){
          alertify.success('Comentario Actualizado');
          estilo_tablas2();
          cargar_datos();
        }
       }
    });
    return false;
  }
  function act_hora1(numero){
    if ($('#ihora1'+numero).hasClass('hidden')){
      $('#ihora1'+numero).removeClass('hidden');  
    }
    else{
      $('#ihora1'+numero).addClass('hidden');
    }
  }
  function act_hora2(numero){
    if ($('#ihora2'+numero).hasClass('hidden')){
      $('#ihora2'+numero).removeClass('hidden');  
    }
    else{
      $('#ihora2'+numero).addClass('hidden');
    }
  }
  function comentario(numero) {
    if ($('#icomentario'+numero).hasClass('hidden')){
      $('#icomentario'+numero).removeClass('hidden');  
    }
    else{
      $('#icomentario'+numero).addClass('hidden');
    }
  }
  function actualizar(hora,id,tipo){
    $.ajax({
      url: 'actualizar_hora.php',
      data: '&id='+ id+'&hora='+ hora+'&tipo='+ tipo,
      type: "POST",
      success: function(respuesta) {
        if(respuesta == "ok"){
          alertify.success('Hora Actualizada');
          estilo_tablas2();
        }
       }
    });
  }
  function cajas(numero) {
    if ($('#icajas'+numero).hasClass('hidden')){
      $('#icajas'+numero).removeClass('hidden');  
    }
    else{
      $('#icajas'+numero).addClass('hidden');
    }
  }
  function actualizar_cajas(cajas,id){
    $.ajax({
      url: 'actualizar_cajas.php',
      data: '&id='+ id+'&cajas='+ cajas,
      type: "POST",
      success: function(respuesta) {
        if(respuesta == "ok"){
          alertify.success('Registro Actualizado');
          estilo_tablas2();
          cargar_datos();
        }
       }
    });
  }
  function actualizar_comentario(comentario,id) {
    $.ajax({
      url: 'actualizar_comentario.php',
      data: '&id='+ id+'&comentario='+ comentario,
      type: "POST",
      success: function(respuesta) {
        if(respuesta == "ok"){
          alertify.success('Comentario Actualizado');
          estilo_tablas2();
        }
       }
    });
  }
  function eliminar(id){
    swal({
        title: "¿Está seguro de eliminar actividad?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_actividad.php',
          data: '&id='+ id,
          type: "POST",
          success: function(respuesta) {
            if(respuesta == "ok"){
              alertify.success('Actividad Eliminada');
              estilo_tablas2();
              cargar_datos();
            }
            else{
              alertify.error('Ha Ocurrido un Error');
            }
          }
        });
      }
    });
  }
  function cargar_datos() {
    var id_promotor = $('#promotor').val();
    var fecha       = $('#fecha').val();
    $.ajax({
      type: "POST",
      url: 'consulta_datos.php',
      data: {'id_promotor':id_promotor,'fecha':fecha}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        var array = eval(respuesta);
        $('#hora_entrada').val(array[0]);
        $('#hora_salida').val(array[1]);

        if(array[2] == 0){
          $('#cajas').removeAttr('readonly');
          $('#cajas_e').val("1");
        }else{
          $('#cajas').attr('readonly',true);
          $('#cajas_e').val("0");
        }
        if(array[1] == null){
          $('#boton_salida').removeAttr('disabled');
        }else{
          $('#boton_salida').attr('disabled',true);
        }
        // if(array[4] == 0){
        //   $('#eliminar_entrada').removeAttr('disabled');
        // }else{
        //   $('#eliminar_entrada').attr('disabled',true);
        // }
        $('#cajas').val(array[2]);

        $('#id_entrada').val(array[3]);
        estilo_tablas2();
      }
    });
  }
  function estilo_tablas () {
    $('#lista_promotores_activos').dataTable().fnDestroy();
    $('#lista_promotores_activos').DataTable( {
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
        "url": "tabla_promotores_activos.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "#" },
        { "data": "NombreP" },
        { "data": "Compañia" },
        { "data": "Actividad" },
        { "data": "HE" }
      ]
    });
  }

  function estilo_tablas2() {
    var id_promotor = $('#promotor').val();
    var fecha       = $('#fecha').val();

    $('#lista_actividades').dataTable().fnDestroy();
    $('#lista_actividades').DataTable( {
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
        "url": "tabla_actividades.php",
        "dataSrc": "",
        "data":{'id_promotor':id_promotor,'fecha': fecha}
      },
      "columns": [
        { "data": "#" },
        { "data": "Actividad" },
        { "data": "HoraI" },
        { "data": "HoraF" },
        { "data": "Comentario" },
        { "data": "Cajas" },
        { "data": "Eliminar" }
      ]
    });
  }

  $('#promotor').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity,
    ajax: {
      url: "consulta_promotores2.php",
      type: "post",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        var fecha = $('#fecha').val();
        return {
          searchTerm: params.term, // search term
          fecha:fecha
        };
      },
      processResults: function (response) {
        return {
          results: response
        };
      },
      cache: true
    }
  });
  $(".tiempo").inputmask("99:99");
  function efecto(){
    var test = $('.venobox').venobox();
    // close current item clicking on .closeme
    $(document).on('click', '.closeme', function(e){
      test.VBclose();
    });
    // go to next item in gallery clicking on .next
    $(document).on('click', '.next', function(e){
      test.VBnext();
    });
    // go to previous item in gallery clicking on .previous
    $(document).on('click', '.previous', function(e){
      test.VBprev();
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
</html>
