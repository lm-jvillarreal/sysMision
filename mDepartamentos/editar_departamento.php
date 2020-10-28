<?php
  include '../global_seguridad/verificar_sesion.php';
  $id         = $_GET['id'];
  $cadena     = mysqli_query($conexion,"SELECT clave_departamento,nombre,abreviatura,id_agrupacion FROM departamentos WHERE id = '$id'");
  $row_cadena = mysqli_fetch_array($cadena);
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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Editar Departamento</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="clave_departamento">*Clave Departamento</label>
                  <input type="text" name="clave_departamento" id="clave_departamento" class="form-control" value="<?php echo $row_cadena[0]?>">
                  <input type="text" name="id" id="id" value="<?php echo $id;?>" class="hidden">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="nombre_departamento">*Nombre del Departamento</label>
                  <input type="text" name="nombre_departamento" id="nombre_departamento" class="form-control" value="<?php echo $row_cadena[1]?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="abreviatura">*Abreviatura</label>
                  <input type="text" name="abreviatura" id="abreviatura" class="form-control" value="<?php echo $row_cadena[2]?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="abreviatura">*Agrupacion</label>
                  <select name="id_agrupacion" id="id_agrupacion" class="select2" style="width: 100%"></select>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <a class="btn btn-warning" id="guardar" onclick="guardar();">Actualizar</a>
            </div>
            </form>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Departamentos Existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_departamentos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Nombre</th>
                        <th>Clave_Dpto.</th>
                        <th>Abreviatura</th>
                        <th>Agrupacion</th>
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

<?php include '../footer.php'; ?>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  function cargar_tabla_departamentos () {
    $('#lista_departamentos').dataTable().fnDestroy();
    $('#lista_departamentos').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
        "type": "POST",
        "url": "tabla_departamentos.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "#" },
        { "data": "Nombre" },
        { "data": "Clave" },
        { "data": "Abreviatura" },
        { "data": "Agrupacion" },
        { "data": "Editar" },
        { "data": "Eliminar" },
      ]
    });
   }  
  $(function (){
   cargar_tabla_departamentos();
  });
  function guardar(){
    $.ajax({
      url: 'actualizar_departamento.php',
      type: 'POST',
      dateType: 'html',
      data: $('#form_datos').serialize(),
      success:function(respuesta){
          if(respuesta == "ok")
          {
            location.href='index.php';
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
  function mensaje(id){
    swal({
      title: "¿Está seguro de eliminar registro?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_departamento.php',
          data: '&id='+ id,
          type: "POST",
          success: function(respuesta) {
            if(respuesta == "ok"){
              cargar_tabla_departamentos();
              swal("El registro se ha eliminado.", {
                icon: "success",
              });
            }
          }
        });
      } else {
        swal("No se ha eliminado el registro.",{
          icon: "error",
        });
      }
    });
  }
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  });
  function llenar_combo_agrupaciones(id) {
    $.ajax({
      type: "POST",
      url: "combo_agrupaciones.php",
      data: '&id='+ id,
      type: "POST",
      success: function(response)
      { 
        $('#id_agrupacion').html(response).fadeIn();
      }
    });
  }
  llenar_combo_agrupaciones(<?php echo $row_cadena[3];?>);
  function mensaje(id){
    swal({
      title: "¿Está seguro de eliminar registro?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'eliminar_departamento.php',
          data: '&id='+ id,
          type: "POST",
          success: function(respuesta) {
            if(respuesta == "ok"){
              cargar_tabla_departamentos();
              swal("El registro se ha eliminado.", {
                icon: "success",
              });
            }
          }
        });
      } else {
        swal("No se ha eliminado el registro.",{
          icon: "error",
        });
      }
    });
  }
  </script>
</body>
</html>
