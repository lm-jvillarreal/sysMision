<?php
include '../global_seguridad/verificar_sesion.php';
 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
  <link rel="stylesheet" href="libs/css/calendar.css">
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <?php include '../header.php'; ?>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php include 'menuV2.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Órdenes de Compra | Calendario de Proveedores</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="pull-left form-inline"><br>
                  <div class="btn-group">
                    <button class="btn btn-danger" data-calendar-nav="prev"><< Anterior</button>
                    <button class="btn" data-calendar-nav="today">Hoy</button>
                    <button class="btn btn-danger" data-calendar-nav="next">Siguiente >></button>
                  </div>
                  <div class="btn-group">
                    <button class="btn btn-warning" data-calendar-view="year">Año</button>
                    <button class="btn btn-warning active" data-calendar-view="month">Mes</button>
                    <button class="btn btn-warning" data-calendar-view="week">Semana</button>
                    <button class="btn btn-warning" data-calendar-view="day">Dia</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div id="calendar"></div>
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

<?php include '../footer.php'; ?>
<script type="text/javascript" src="libs/js/es-ES.js"></script>
<script src="libs/js/moment.js"></script>
<script src="libs/js/underscore-min.js"></script>
<script src="libs/js/calendar.js"></script>
<!-- Page script -->
<script>
(function($){
  //creamos la fecha actual
  var date = new Date();
  var yyyy = date.getFullYear().toString();
  var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
  var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();

  //establecemos los valores del calendario
  var options = {

    // definimos que los eventos se mostraran en ventana modal
    modal: '#events-modal', 

    // dentro de un iframe
    modal_type:'iframe',    

    //obtenemos los eventos de la base de datos
    events_source: 'obtener_eventos.php', 

    // mostramos el calendario en el mes
    view: 'month',             

    // y dia actual
    day: yyyy+"-"+mm+"-"+dd,   


    // definimos el idioma por defecto
    language: 'es-ES', 

    //Template de nuestro calendario
    tmpl_path: 'libs/tmpls/', 
    tmpl_cache: false,


    // Hora de inicio
    time_start: '08:00', 

    // y Hora final de cada dia
    time_end: '22:00',   

    // intervalo de tiempo entre las hora, en este caso son 30 minutos
    time_split: '30',    

    // Definimos un ancho del 100% a nuestro calendario
    width: '100%', 

    onAfterEventsLoad: function(events)
    {
      if(!events)
      {
        return;
      }
      var list = $('#eventlist');
      list.html('');

      $.each(events, function(key, val)
      {
        $(document.createElement('li'))
        .html('<a href="' + val.url + '">' + val.title + '</a>')
        .appendTo(list);
      });
    },
    onAfterViewLoad: function(view)
    {
      $('.page-header h2').text(this.getTitle());
      $('.btn-group button').removeClass('active');
      $('button[data-calendar-view="' + view + '"]').addClass('active');
    },
    classes: {
      months: {
        general: 'label'
      }
    }
  };


  // id del div donde se mostrara el calendario
  var calendar = $('#calendar').calendar(options); 

  $('.btn-group button[data-calendar-nav]').each(function()
  {
    var $this = $(this);
    $this.click(function()
    {
      calendar.navigate($this.data('calendar-nav'));
    });
  });

  $('.btn-group button[data-calendar-view]').each(function()
  {
    var $this = $(this);
    $this.click(function()
    {
      calendar.view($this.data('calendar-view'));
    });
  });

  $('#first_day').change(function()
  {
    var value = $(this).val();
    value = value.length ? parseInt(value) : null;
    calendar.setOptions({first_day: value});
    calendar.view();
  });
}(jQuery));
</script>
</body>
</html>
