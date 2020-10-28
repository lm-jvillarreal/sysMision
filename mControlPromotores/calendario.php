<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
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
      <link rel="stylesheet" type="text/css" href="../d_plantilla/bower_components/fullcalendar/dist/fullcalendar.min.css">
      <link rel="stylesheet" type="text/css" href="../d_plantilla/bower_components/fullcalendar/dist/fullcalendar.print.css" media="print">
      <!-- <link rel="stylesheet" href="../bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print"> -->
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
      <section class="content-header">
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="box box-danger">
              <div class="box-body no-padding">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
              </div>
              <br>
          </div>
          <!-- /.col -->
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
  <!-- Page script -->
  <script src="../d_plantilla/bower_components/moment/moment.js"></script>
  <script src="../d_plantilla/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
  <script src="../d_plantilla/bower_components/jquery-ui/jquery-ui.min.js"></script>
  <script src="../d_plantilla/bower_components/fullcalendar/dist/locale-all.js"></script>
  <script>
    $(document).ready(function() {
      var date = new Date();
      var d = date.getDate();
      var m = date.getMonth();
      var y = date.getFullYear();

      var calendar = $('#calendar').fullCalendar({
        height: 'auto',
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        buttonText: {
          today: 'Hoy',
          month: 'Mes',
          week: 'Semana',
          day: 'Dia'
        },
        locale: 'es',
        editable: true,
        allDayDefault: true,
        events: 'recibir_eventos.php',
        // eventColor: '#f56954',
        selectable: true,
        selectHelper: true,
        // showNonCurrentDates: false,
        select: function(start, end, allDay) {
          alertify.prompt('Nuevo Evento', '',
            function(evt, title) {
              inicio = $.fullCalendar.formatDate(start, "YYYY-MM-DD hh:mm:ss");
              final = $.fullCalendar.formatDate(end, "YYYY-MM-DD hh:mm:ss");
              $.ajax({
                url: 'insertar_evento.php',
                data: 'title=' + title + '&start=' + inicio + '&end=' + final,
                type: "POST",
                success: function(json) {
                  if (json == "ok") {
                    alertify.success('Evento Añadido');
                    calendar.fullCalendar('removeEvents');
                    calendar.fullCalendar('refetchEvents');
                    llenar_notificaciones();
                  } else {
                    alertify.error('Ha Ocurrido un Error');
                  }
                }
              });
              calendar.fullCalendar('renderEvent', {
                  title: title,
                  start: start,
                  end: end,
                  allDay: allDay
                },
                true // make the event "stick"
              );
            },
            function() {
              calendar.fullCalendar('unselect');
            });
        },
        editable: true,
        eventDrop: function(event, delta) {
          inicio = $.fullCalendar.formatDate(event.start, "YYYY-MM-DD hh:mm:ss");
          final = $.fullCalendar.formatDate(event.end, "YYYY-MM-DD hh:mm:ss");
          $.ajax({
            url: 'actualizar_evento.php',
            data: 'title=' + event.title + '&start=' + inicio + '&end=' + final + '&id=' + event.id,
            type: "POST",
            success: function(json) {
              if (json == "ok") {
                alertify.success('Evento Actualizado');
                llenar_notificaciones();
              } else {
                alertify.error('Ha Ocurrido un Error');
              }
            }
          });
        },
        eventResize: function(event) {
          inicio = $.fullCalendar.formatDate(event.start, "YYYY-MM-DD hh:mm:ss");
          final = $.fullCalendar.formatDate(event.end, "YYYY-MM-DD hh:mm:ss");
          $.ajax({
            url: 'actualizar_evento.php',
            data: 'title=' + event.title + '&start=' + inicio + '&end=' + final + '&id=' + event.id,
            type: "POST",
            success: function(json) {
              if (json == "ok") {
                alertify.success('Evento Actualizado');
                llenar_notificaciones();
              } else {
                alertify.error('Ha Ocurrido un Error');
              }
            }
          });
        },
        eventRender: function(event, element) {
          element.click(function() {
            swal({
                title: "¿Está seguro de eliminar registro?",
                icon: "warning",
                buttons: ["No", "Si"],
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                  $('#calendar').fullCalendar('removeEvents', event.id);
                  $.ajax({
                    url: 'eliminar_evento.php',
                    data: '&id=' + event.id,
                    type: "POST",
                    success: function(respuesta) {
                      if (respuesta == "ok") {
                        alertify.success('Evento Eliminado');
                        llenar_notificaciones();
                      } else {
                        alertify.error('Ha Ocurrido un Error');
                      }
                    }
                  });
                }
              });
          });
        }
      });
    });
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
</body>
</html>