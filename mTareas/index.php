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
      <div class="row" <?php echo $solo_lectura; ?>>
        <div class="col-md-12">
          <div class="col-md-4">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Lista de Catergorias</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="tabla">
                    <div class="table-responsive">
                      <table id="lista_categorias" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th width="5%">#</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                        </tbody>  
                      </table>
                    </div>
                  </div>
                </div>
                <div class="box-footer pull-right">
                  <a class="btn btn-danger" href='#' data-toggle = 'modal' data-target = '#modal-default' target='blank'><span><i class="fa fa-plus"></i> Nueva Categoria</span></a>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
          <div class="col-md-4">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Lista de Tareas</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                <input type="hidden" name="folio_actual" id="folio_actual" value="0">
                <input type="hidden" name="tarea_actual" id="tarea_actual" value="0">
                <ul class="todo-list" id="contenedor_tareas">
                  
                </ul>
                <hr>
                <!-- <ul class="todo-list" id="contenedor_pasos">
                  
                </ul> -->
              </div>
              <!-- /.box-body -->
              <div class="box-footer clearfix no-border">
                <button type="button" class="btn btn-warning pull-right" onclick="nueva()"><i class="fa fa-plus"></i> Nueva Tarea</button>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Pasos</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                <ul class="todo-list" id="contenedor_pasos">
                  
                </ul>
              </div>
              <!-- /.box-body -->
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
 <?php include 'modal.php'; ?>
  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php include '../footer.php'; ?>
<!-- Page script -->
<script src="../d_plantilla/plugins/jQueryUI/jquery-ui.min.js"></script>
<script>
  function estilo_tablas(){
    $('#lista_categorias').dataTable().fnDestroy();
    $('#lista_categorias').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
        "type": "POST",
        "url": "tabla_categorias.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Acciones" }
      ]
    });
  }
  function estilo_tablas2(folio){
    $('#lista_usuarios').dataTable().fnDestroy();
    $('#lista_usuarios').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
        "type": "POST",
        "url": "tabla_usuarios2.php",
        "dataSrc": "",
        "data":{'folio':folio}
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Eliminar" }
      ]
    });
  }
  function tareas(folio,tarea){
    $('#contenedor_pasos').empty();
    $.ajax({
      url: 'datos_tareas.php',
      type: "POST",
      dateType: "html",
      data: {'folio':folio,'tarea':tarea},
      success: function(respuesta) {
        $('#contenedor_tareas').html(respuesta);
        $('#folio_actual').val(folio);
      }
    });
  }
  function editar_tarea(numero) {
    if($('#nombre_tarea_'+numero).hasClass('hidden')){
      $('#nombre_tarea_'+numero).removeClass('hidden');
      $('#tarea'+numero).addClass('hidden');
    }else{
      $('#nombre_tarea_'+numero).addClass('hidden');
      $('#tarea'+numero).removeClass('hidden');
    }
  }
  function editar_paso(numero){
    if($('#nombre_paso_'+numero).hasClass('hidden')){
      $('#nombre_paso_'+numero).removeClass('hidden');
      $('#paso'+numero).addClass('hidden');
    }else{
      $('#nombre_paso_'+numero).addClass('hidden');
      $('#paso'+numero).removeClass('hidden');
    }
  }
  function eliminar_tarea(id){
    var tarea = $('#tarea_actual').val();
    var folio = $('#folio_actual').val();
    swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
          url: 'eliminar_tarea.php',
          type: "POST",
          dateType: "html",
          data: {'id':id},
          success: function(respuesta) {
            if(respuesta == "ok"){
              alertify.success("Registro Eliminado Correctamente");
              tareas(folio,tarea);
            }else{
              alertify.errro("Ha Ocurrido un Error");
            }
          }
      });
        }
      });
  }
  function eliminar_paso(id){
    var tarea = $('#tarea_actual').val();
    swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
          url: 'eliminar_paso.php',
          type: "POST",
          dateType: "html",
          data: {'id':id},
          success: function(respuesta) {
            if(respuesta == "ok"){
              alertify.success("Registro Eliminado Correctamente");
              // $('#contenedor_pasos').empty();
              tareas2(tarea);
            }else{
              alertify.errro("Ha Ocurrido un Error");
            }
          }
      });
        }
      });
  }
  function nueva(){
    var folio = $('#folio_actual').val();
    if(folio == 0){
      alertify.error("Debes seleccionar una categoria");
    }else{
      $('#nuevo').show();
      $('#nueva_tarea').focus();
    }
  }
  function insertar_nueva(valor){
    var folio = $('#folio_actual').val();
    var tarea = $('#tarea_actual').val();

    $.ajax({
      url: 'insertar_tarea.php',
      data: {'valor':valor,'folio':folio},
      type: "POST",
      success: function(respuesta) {
        if(respuesta == "ok"){
          alertify.success('Registro Añadido Correctamente');
          tareas(folio,tarea);
        }
        else if (respuesta == "duplicado"){
            alertify.error('Ya Existe este Registro');
        }else if (respuesta == "vacio"){
            alertify.error('Verifica Campos');
        }else{
          alertify.error('Ha Ocurrido un Error');
        }
       }
    });
  }
  function add_calendar(id){
    var folio = $('#folio_actual').val();
    var tarea = $('#tarea_actual').val();
    $.ajax({
      url: 'add_calendar.php',
      data: '&id='+id ,
      type: "POST",
      success: function(respuesta) {
        if(respuesta == "ok"){
          alertify.success('Registro Añadido al Calendario');
          llenar_notificaciones();
          tareas(folio,0);
        }
        else if (respuesta == "duplicado"){
            alertify.error('Ya existe en el Calendario');
        }else{
          alertify.error('Ha Ocurrido un Error');
        }
       }
    });
  }
  function terminar_tarea(id){
    $.ajax({
        url: 'terminar_tarea.php',
        type: "POST",
        dateType: "html",
        data: {'id':id},
        success: function(respuesta) {
          if(respuesta == "ok"){
            // alertify.success("Registro Eliminado Correctamente");
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        }
    });
  }
  function terminar_paso(id){
    $.ajax({
        url: 'terminar_paso.php',
        type: "POST",
        dateType: "html",
        data: {'id':id},
        success: function(respuesta) {
          if(respuesta == "ok"){
            // alertify.success("Registro Eliminado Correctamente");
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        }
    });
  }
  function actualizar_tarea(numero,id) {
    var nombre_tarea = $('#nombre_tarea_'+numero).val();
    $.ajax({
        url: 'actualizar_tarea.php',
        type: "POST",
        dateType: "html",
        data: {'nombre_tarea':nombre_tarea,'id':id},
        success: function(respuesta) {
          if(respuesta == "ok"){
            alertify.success("Registro Actualizado Correctamente");
            var folio = $('#folio_actual').val();
            tareas(folio);
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        }
    });
  }
  function actualizar_paso(numero,id) {
    var nombre_paso = $('#nombre_paso_'+numero).val();
    $.ajax({
        url: 'actualizar_paso.php',
        type: "POST",
        dateType: "html",
        data: {'nombre_paso':nombre_paso,'id':id},
        success: function(respuesta) {
          if(respuesta == "ok"){
            alertify.success("Registro Actualizado Correctamente");
            var tarea = $('#tarea_actual').val();
            tareas2(tarea);
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        }
    });
  }
  estilo_tablas();
  $('#usuarios').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
     url: "combo_usuarios.php",
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
  $("#btn-guardar").click(function(){
    var url = "insertar_categoria.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: $('#form_datos').serialize(),
        success: function(respuesta) {
          if (respuesta=="ok") {
            $('#form_datos')[0].reset();
            $('#usuarios').val(null).trigger('change');
            estilo_tablas();
            $('#modal-default').modal('hide');
            alertify.success("Registro Guardado Correctamente");
          }else if(respuesta == "duplicado"){
            alertify.error("Registro Duplicado");
          }else if(respuesta == "vacio"){
            alertify.error("Verifica Campos");
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
      return false;
    });
  function eliminar(folio){
    swal({
        title: "¿Está seguro de eliminar registro?",
        icon: "warning",
        buttons: ["No", "Si"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
        url: 'eliminar_categoria.php',
        type: "POST",
        dateType: "html",
        data: {'folio':folio},
        success: function(respuesta) {
          if (respuesta=="ok") {
            alertify.success("Registro Guardado Correctamente");
            estilo_tablas();
          }else{
            alertify.error("Ha Ocurrido un Error");
          }
        }
      });
        }
      });
  }
  function eliminar_agenda(folio){
    var folio_a = $('#folio_actual').val();
    var tarea = $('#tarea_actual').val();
    $.ajax({
      url: 'delete_calendar.php',
      type: "POST",
      dateType: "html",
      data: {'folio':folio},
      success: function(respuesta) {
        if (respuesta=="ok") {
          alertify.success("Registro Eliminado del Calendario");
          tareas(folio_a,0);
          llenar_notificaciones();
        }else{
          alertify.error("Ha Ocurrido un Error");
        }
      }
    });
  }
  $('#modal-default').on('show.bs.modal', function(e){
    var folio = $(e.relatedTarget).data().id;
    var url = "consulta_datos_categoria.php"; // El script a dónde se realizará la petición.
    $.ajax({
      type: "POST",
      url: url,
      data: {folio:folio}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        $('#id_categoria').val(folio);
        $('#form_datos')[0].reset();
        $('#usuarios').val(null).trigger('change');
        var array = eval(respuesta);
        $('#nombre').val(array[0]);
        $('#descripcion').val(array[1]);
        if(folio != null){
          estilo_tablas2(folio);
          $('#tabla_usuarios').show();
          $('#invitar').hide();
        }
      }
    });
  });
  function tareas2(tarea){
    $('#tarea_actual').val(tarea);
    var folio = $('#folio_actual').val();
    $.ajax({
      url: 'datos_tareas2.php',
      type: "POST",
      dateType: "html",
      data: {'tarea':tarea},
      success: function(respuesta) {
        tareas(folio,tarea);
        $('#contenedor_pasos').html(respuesta);
      }
    });
  }
  function insertar_paso(paso){
    var tarea = $('#tarea_actual').val();
    $.ajax({
      url: 'insertar_paso.php',
      type: "POST",
      dateType: "html",
      data: {'paso':paso,'tarea':tarea},
      success: function(respuesta) {
        if(respuesta == "ok"){
          alertify.success('Registro Añadido Correctamente');
          tareas2(tarea);
        }else if (respuesta == "duplicado"){
          alertify.error('Ya Existe este Registro');
        }else if (respuesta == "vacio"){
          alertify.error('Verifica Campos');
        }else{
          alertify.error('Ha Ocurrido un Error');
        }
      }
    });
  }
</script>
<script>
  $('.todo-list').todoList({
    onCheck  : function () {
      window.console.log($(this), 'The element has been checked');
    },
    onUnCheck: function () {
      window.console.log($(this), 'The element has been unchecked');
    }
  });
  $('.todo-list').sortable({
    placeholder         : 'sort-highlight',
    handle              : '.handle',
    forcePlaceholderSize: true,
    zIndex              : 999999
  });
</script>
</body>
</html>
