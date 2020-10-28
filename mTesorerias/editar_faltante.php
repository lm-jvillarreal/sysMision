<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');

  $folio = $_GET['folio'];
  $cadena_fecha = mysqli_query($conexion,"SELECT fecha FROM faltantes WHERE folio = '$folio'");
  $row_fecha = mysqli_fetch_array($cadena_fecha);

  $cadena = mysqli_query($conexion,"SELECT id, folio,moneda,faltante,valor,fecha FROM faltantes WHERE folio = '$folio'");

 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
  <link rel="stylesheet" href="../mJuntas/estilos.css">
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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Captura de Faltantes de Morralla</h3>
          </div>
          <div class="box-body" onload="cargar_tabla();">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha:</label>
                  <div class="input-group date form_date" data-date="<?php echo $row_fecha[0] ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $row_fecha[0] ?>" readonly id="fecha" name="fecha" form="lista">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive text-center">
                  <form id="lista">
                  <table id="lista_morralla" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Moneda</th>
                        <th>Faltante</th>
                        <th>Valor</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $morralla = array(1 =>'20.00',2=> '10.00',3 =>'5.00',4 => '2.00',5 => '1.00',
                                    6 => '0.50',7 => '0.20',8 => '0.10');
                        $i = 1;
                          while ($row_faltante = mysqli_fetch_array($cadena)) { 
                      ?>
                          <tr>
                            <td>
                              <?php echo $i;?>
                              <input type="text" name="folio" value="<?php echo $folio;?>" class="hidden">
                            </td>
                            <td>$ <?php echo $morralla[$i];?>
                              <input type="text" value="<?php echo $morralla[$i];?>" class="hidden" name="morralla[]">
                            </td>
                            <td>
                              <input  value="<?php echo $row_faltante[3]?>" type="text" name="faltante[]" id="faltante<?php echo $i;?>" class="form-control" onkeyup="if(event.keyCode == 13)llenar(this.value,'<?php echo $morralla[$i];?>','<?php echo $i;?>')">
                            </td>
                            <td>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    $
                                  </div>
                                  <input value="<?php echo $row_faltante[4]?>" type="text" id="resultado<?php echo $i;?>" class="form-control" readonly name="resultado[]">
                                </div>
                            </td>
                          </tr>
                      <?php
                          $i ++;
                        }
                      ?>
                    </tbody>  
                  </table>
                  </form>
                </div>
              </div>
            </div>
          <div class="box-footer text-right">
            <div class="col-md-12">
              <button onclick="guardar();" class="btn btn-warning" id="guardar">Actualizar</button>
            </div>
          </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Faltantes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_faltante" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Folio</th>
                        <th>Usuario</th>
                        <th>Sucursal</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        <th>Ver</th>
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
<script>
  $('#faltante'+1).focus();
</script>
<script>
  function guardar(){
    $.ajax({
      url: 'actualizar_faltante.php',
      type: 'POST',
      dateType: 'html',
      data: $('#lista').serialize(),
      success:function(respuesta){
          if(respuesta == "ok")
          {
            alertify.success("Se ha Actualizado Correctamente",2);
            cargar_tabla(<?php echo $folio?>);
          }
          else if (respuesta == "vacio")
          {
            alertify.error("Verifica Campos",2);
          }
          else
          {
            alertify.error("Ha Ocurrido un Error",2);
          }
      }
    });
  }
</script>
<script>
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  })
</script>
<script>
  function llenar(cantidad,morralla,id){
    if(cantidad == "")
    {
      cantidad = 0;
      $('#faltante'+id).val(cantidad);
    }
      resultado = cantidad * morralla;

      $('#resultado'+id).val(resultado.toFixed(2));

      total = parseInt(id) + 1;

      if (total <= 8)
      {
        $('#faltante'+total).focus();
      }
  }
  function cargar_tabla(folio){
    $('#lista_faltante').dataTable().fnDestroy();
    $('#lista_faltante').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      "ajax": {
          "type": "POST",
          "url": "tabla_morralla.php",
          "dataSrc": "",
          "data": {'folio':folio}
      },
      "columns": [
          { "data": "#" },
          { "data": "Folio" },
          { "data": "Usuario" },
          { "data": "Sucursal" },
          { "data": "Fecha" },
          { "data": "Hora" },
          { "data": "Editar" },
          { "data": "Eliminar" },
          { "data": "Ver" },
      ]
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
<script>
  cargar_tabla(<?php echo $folio?>);
</script>
</body>
</html>