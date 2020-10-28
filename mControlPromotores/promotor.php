<?php
  include '../global_seguridad/verificar_sesion.php';
  
  date_default_timezone_set('America/Monterrey');
  $fecha = date("Y-m-j"); 

  $id_promotor = $_GET['id'];
  $cadena = mysqli_query($conexion,"SELECT cantidad_horas,CONCAT(nombre,' ',ap_paterno),compañia FROM promotores WHERE id = '$id_promotor'");
  $row = mysqli_fetch_array($cadena);
  $cadena2 = mysqli_query($conexion,"SELECT hora_entrada,fecha FROM registro_entrada WHERE id_promotor = '$id_promotor' AND fecha = '$fecha' ");

  $row2 = mysqli_fetch_array($cadena2);

  $fecha_bd = $row2[0].' '.$row2[1];

  $minutos = substr($row[0],3,-3);
  $horas   = substr($row[0],0,-6);
  
  $newDate = strtotime ( '+'.$horas.' hour' , strtotime ($fecha_bd) ) ; 
  $newDate = strtotime ( '+'.$minutos.' minute' , $newDate ) ; 
  $newDate = date ( 'Y-m-j H:i:s' , $newDate); 
 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
  <script type="text/javascript">
    var dateFrom = new Date("<?php echo $newDate;?>");
    // Set the date we're counting down to
    var countDownDate = new Date(dateFrom).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

      // Get todays date and time
      var now = new Date().getTime();

      // Find the distance between now and the count down date
      var distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Display the result in the element with id="demo"
      document.getElementById("demo").innerHTML = hours + "h "
      + minutes + "m " + seconds + "s ";

      // If the count down is finished, write some text
      if (distance < 0) {
        clearInterval(x);
        // audio.play();
        document.getElementById("demo").innerHTML = "Tiempo Terminado";
      }
    }, 1000);
  </script>
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
            <h3 class="box-title">Control de Entrada</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-9">
                  <font size="3">
                    <p>Promotor:<b> <?php echo $row[1];?></b></p>
                    <p>Compañia:<b> <?php echo $row[2];?></b></p>
                  </font>
                </div>
                <div class="col-md-3">
                  <font size="5px"><b><p id="demo"></p></b></font>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>*Añadir Actividad</label>
                    <input type="text" name="actividad" id="actividad" class="form-control"  onkeyup="if(event.keyCode ==13)añadir(this.value,<?php echo $id_promotor;?>);">
                  </div>
                </div>
              </div>
            </div>   
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Actividades Asignadas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_actividades" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="20%">Actividad</th>
                        <th width="10%">Iniciar/Terminar</th>
                        <th width="20%">Tiempo</th>
                        <th width="20%">Cantidad Cajas</th>
                        <th width="20%">Comentario</th>
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
  <?php include '../footer2.php'; ?>
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
  var intevalo = setInterval('estilo_tablas(<?php echo $id_promotor;?>)',60000);
</script>
<script>
  function estilo_tablas (id_promotor) {
    $('#lista_actividades').dataTable().fnDestroy();
    $('#lista_actividades').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
        "type": "POST",
        "url": "tabla_actividades.php",
        "dataSrc": "",
        "data":{'id_promotor':id_promotor}
      },
      "columns": [
        { "data": "#" },
        { "data": "Actividad" },
        { "data": "Boton" },
        { "data": "Cronometro"},
        { "data": "CantidadC"},
        { "data": "Comentario"}
      ]
    });
   }  
  $(function (){
   estilo_tablas(<?php echo $id_promotor;?>);
  });
  function iniciar(id_actividad){
    $.ajax({
      type: "POST",
      url: 'iniciar_actividad.php',
      data: {'id_actividad':id_actividad}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        if(respuesta == "ok"){
          $('#actividad').val("");
          estilo_tablas(<?php echo $id_promotor;?>);
        }
      }
    });
  }
  function act_cajas(cajas,id_actividad){
    if (cajas != 0){
      $.ajax({
        type: "POST",
        url: 'cajas.php',
        data: {'cajas':cajas,'id_actividad':id_actividad}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if(respuesta == "ok"){
            estilo_tablas(<?php echo $id_promotor;?>);
          }
        }
      });
    }
  }
  function act_comentario(comentario,id_registro){
    //if (cajas != ""){
      $.ajax({
        type: "POST",
        url: 'comentario.php',
        data: {'comentario':comentario,'id_registro':id_registro}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if(respuesta == "ok"){
            estilo_tablas(<?php echo $id_promotor;?>);
          }
        }
      });
    // }
  }
  function añadir(actividad,id_promotor){
    if (actividad != ""){
      $.ajax({
        type: "POST",
        url: 'nueva_actividad.php',
        data: {'actividad':actividad, 'id_promotor':id_promotor}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          if(respuesta == "ok"){
            estilo_tablas(<?php echo $id_promotor;?>);
          }
        }
      });
    }
  }
</script>
<script>
  function crear_otros(){
    var input = document.createElement("INPUT");
    input.classList.add('form-control');
    input.name = "actividades[]";
    input.placeholder = "Nombre Actividad";
    input.id = 'o';
    
    document.getElementById("concepto").appendChild(input);

    var br = document.createElement("BR");
    document.getElementById("concepto").appendChild(br);
    br.id = 'br';
  }
</script>    
</body>
</html>
